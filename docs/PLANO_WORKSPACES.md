# Plano de Implementação - Sistema de Workspaces

## 📋 Entendimento do Sistema Atual

### Situação Atual Identificada:

1. **Estrutura de Rotas:**

   - Rotas públicas atualmente usam `username` do usuário para acesso à página pública
   - Middleware `Bio` busca usuário por `username` e injeta na requisição
   - Rotas são registradas dinamicamente através do `ExtenedServiceProvider` com prefixo `@{bio}` ou subdomínio
   - Sistema já possui suporte para domínios customizados via tabela `domains`

2. **Estrutura de Workspaces (Já Implementada Parcialmente):**

   - Tabela `workspaces` criada com todos os campos necessários (slug, settings, bio, etc.)
   - Migration que adiciona `workspace_id` às tabelas: `blocks`, `highlights`, `elements`, `visitors`
   - Modelo `Workspace` com relacionamento com `User`
   - Sistema de sessão usando `active_workspace_id` para gerenciar workspace ativa
   - Controller `WorkspaceController` com CRUD básico

3. **Problemas Identificados:**
   - ✅ Rotas públicas ainda usam `username`, deveriam usar `workspace->slug`
   - ✅ Middleware `Bio` busca por `username`, deveria buscar por `workspace->slug`
   - ✅ Elementos/Blocks/Highlights não estão filtrando por `workspace_id` corretamente
   - ✅ Validação de limite de workspaces não está funcionando corretamente
   - ✅ Primeira workspace não está sendo protegida contra deleção
   - ✅ Configurações do workspace não estão sendo usadas nas rotas públicas
   - ✅ Domínios públicos ainda estão vinculados ao usuário, não ao workspace

---

## 🎯 Requisitos do Sistema

### Comportamento Esperado:

1. **Limites de Workspaces:**

   - Usuários podem criar X workspaces baseado no plano (`workspaces_limit`)
   - Limite deve contar todas as workspaces do usuário
   - Cada workspace tem sua própria rota pública (slug)
   - Cada workspace tem seu próprio domínio público (se configurado)

2. **Workspace Principal (Primeira):**

   - A primeira workspace criada pelo usuário NÃO pode ser deletada
   - Deve estar marcada como `is_default = 1`
   - Fica permanentemente vinculada ao usuário
   - Slug da primeira workspace pode ser o mesmo do username (compatibilidade)

3. **Workspaces Secundárias:**

   - Todas as outras workspaces podem ser deletadas
   - Vinculadas ao usuário que criou, mas podem ser removidas
   - Cada uma tem seu próprio slug único

4. **Isolamento de Dados:**

   - Cada workspace tem sua própria:
     - **Rota pública**: `/{workspace->slug}` (em vez de `/{username}`)
     - **Configurações**: bio, avatar, settings, background, etc.
     - **Audiência/Visitors**: isolados por `workspace_id`
     - **Elementos/Blocks/Highlights**: filtrados por `workspace_id`
     - **Domínio público**: pode ter domínio customizado próprio

5. **Configurações:**
   - Configurações de **Workspace** (bio, avatar, theme, etc.) são separadas por workspace
   - Configurações de **Usuário** (email, password, etc.) são compartilhadas
   - Helper `user()` deve retornar dados do workspace ativo quando em contexto público

---

## 📝 Plano de Implementação

### Fase 1: Ajustes no Modelo e Migrations

#### 1.1. Adicionar campo `workspace_id` ao modelo Element

- ✅ Já existe na migration, verificar se está no modelo

#### 1.2. Adicionar campo `is_first` ou usar `is_default` para proteger primeira workspace

- ✅ Já existe `is_default`, usar para identificar primeira workspace

#### 1.3. Migration para garantir que primeira workspace não pode ser deletada

- Criar migration que marca primeira workspace como `is_default = 1` se não estiver
- Adicionar constraint no código (não no banco, pois pode causar problemas)

### Fase 2: Atualizar Rotas Públicas

#### 2.1. Modificar Middleware `Bio` (app/Http/Middleware/Bio.php)

- Atualizar para buscar `Workspace` por `slug` em vez de `User` por `username`
- Manter compatibilidade: se não encontrar workspace, buscar por username (fallback)
- Injetar workspace na requisição e carregar relacionamentos

#### 2.2. Atualizar Trait `UserBioInfo` (app/Traits/UserBioInfo.php)

- Modificar para buscar workspace por slug
- Carregar dados do workspace ao invés do usuário diretamente

#### 2.3. Atualizar Controller `BioController`

- Filtrar blocks, highlights por `workspace_id`
- Usar configurações do workspace em vez do usuário

#### 2.4. Atualizar `ExtenedServiceProvider`

- Manter registro de rotas, mas agora usando workspace slug
- Atualizar prefixo para usar workspace slug

### Fase 3: Ajustar Sistema de Elementos/Render

#### 3.1. Atualizar `App\Element\Render`

- Modificar para buscar elemento e verificar `workspace_id`
- Garantir que elementos são renderizados apenas do workspace correto

#### 3.2. Atualizar Controllers de Elementos

- Todos os controllers de criação devem usar `session('active_workspace_id')`
- Verificar se já está sendo feito (parece que sim)

#### 3.3. Atualizar Rotas de Renderização de Elementos

- Garantir que rotas de elementos verificam workspace_id
- Elementos devem ser acessíveis apenas via sua workspace

### Fase 4: Ajustar Validação de Limites

#### 4.1. Atualizar `WorkspaceController@store`

- Verificar limite corretamente: `$user->workspaces()->count() >= $limit`
- Verificar se já está funcionando (parece estar correto)

#### 4.2. Proteger Primeira Workspace

- Atualizar `WorkspaceController@delete`
- Verificar se `is_default = 1` e não permitir deleção
- Ou verificar se é a primeira criada (orderBy('created_at', 'ASC')->first())

### Fase 5: Separar Configurações

#### 5.1. Atualizar Helper `user()` (app/Helpers/Glob.php)

- Quando em contexto público (via middleware Bio), retornar dados do workspace
- Quando em contexto autenticado, usar workspace ativa da sessão
- Manter compatibilidade com código existente

#### 5.2. Criar Helper `workspace()`

- Novo helper para acessar workspace atual
- Similar ao `user()`, mas retorna workspace

#### 5.3. Atualizar Views

- Garantir que views usam dados do workspace quando em contexto público
- Views administrativas continuam usando dados do usuário

### Fase 6: Domínios Customizados

#### 6.1. Adicionar `workspace_id` à tabela `domains`

- Migration para adicionar campo
- Atualizar model `Domain`

#### 6.2. Atualizar Middleware `Bio`

- Verificar domínio customizado e buscar workspace correspondente
- Manter fallback para domínios vinculados ao usuário (compatibilidade)

### Fase 7: Sistema de Audiência/Estatísticas

#### 7.1. Garantir que Visitors são registrados por workspace

- Já tem `workspace_id` na migration, verificar se está sendo usado

#### 7.2. Atualizar queries de estatísticas

- Filtrar por `workspace_id` em todas as queries de analytics

---

## 🔧 Arquivos que Precisam ser Modificados

### Core:

1. `app/Http/Middleware/Bio.php` - Buscar workspace por slug
2. `app/Traits/UserBioInfo.php` - Usar workspace em vez de user
3. `app/Helpers/Glob.php` - Atualizar helper `user()` para usar workspace
4. `extension/Bio/Http/Controllers/BioController.php` - Filtrar por workspace_id
5. `extension/Bio/Providers/ExtenedServiceProvider.php` - Rotas por workspace

### Workspaces:

6. `extension/Mix/Http/Controllers/WorkspaceController.php` - Proteger primeira workspace
7. `app/Models/Workspace.php` - Adicionar métodos helper se necessário

### Elementos:

8. `app/Element/Render.php` - Verificar workspace_id ao renderizar
9. Todos os controllers de elementos - Já parecem estar usando workspace_id

### Domínios:

10. `app/Models/Domain.php` - Adicionar workspace_id
11. Migration para adicionar workspace_id em domains

---

## ⚠️ Pontos de Atenção

1. **Compatibilidade com dados existentes:**

   - Usuários existentes já têm workspace criada (via migration)
   - Slug da primeira workspace = username (compatibilidade)
   - Domínios existentes devem continuar funcionando

2. **Sessão e Contexto:**

   - Contexto público: usar workspace da URL
   - Contexto autenticado: usar workspace da sessão
   - Helper `user()` deve funcionar em ambos os contextos

3. **Performance:**

   - Queries devem usar índices em `workspace_id`
   - Evitar N+1 queries ao carregar workspace

4. **Segurança:**
   - Verificar permissões ao acessar workspace
   - Usuários só podem acessar suas próprias workspaces
   - Rotas públicas devem validar que workspace está ativa

---

## 🧪 Testes Necessários

1. Criar múltiplas workspaces e verificar limites
2. Tentar deletar primeira workspace (deve falhar)
3. Acessar páginas públicas por workspace slug
4. Verificar isolamento de dados entre workspaces
5. Verificar domínios customizados por workspace
6. Testar migração de dados existentes

---

## 📅 Ordem de Implementação Recomendada

1. ✅ Fase 1: Modelo e Migrations (já feito parcialmente)
2. ✅ Fase 2: Rotas Públicas (crítico) - IMPLEMENTADO
3. ✅ Fase 3: Elementos/Render (importante) - IMPLEMENTADO
4. ✅ Fase 4: Validação de Limites (importante) - IMPLEMENTADO
5. ✅ Fase 5: Separar Configurações (importante) - IMPLEMENTADO (parcial)
6. ✅ Fase 6: Domínios Customizados - IMPLEMENTADO (migration criada)
7. ⏳ Fase 7: Audiência/Estatísticas (pode ser depois)

## ✅ Mudanças Implementadas

### Fase 2: Rotas Públicas

- ✅ `app/Http/Middleware/Bio.php` - Atualizado para buscar workspace por slug, com fallback para username
- ✅ `app/Traits/UserBioInfo.php` - Atualizado para usar workspace em vez de apenas user
- ✅ `extension/Bio/Http/Controllers/BioController.php` - Filtra blocks/highlights por workspace_id

### Fase 3: Elementos/Render

- ✅ `app/Element/Render.php` - Adicionada verificação de workspace_id ao renderizar elementos
- ✅ `app/Models/YettiBlock.php` - Adicionado workspace_id ao fillable

### Fase 4: Validação de Limites

- ✅ `extension/Mix/Http/Controllers/WorkspaceController.php` - Validação melhorada
- ✅ Proteção da primeira workspace contra deleção implementada

### Fase 5: Separar Configurações

- ✅ `app/Helpers/Glob.php` - Helper user() atualizado para usar workspace em contexto público e autenticado

### Fase 6: Domínios

- ✅ `database/migrations/2026_01_07_000003_add_workspace_id_to_domains_table.php` - Migration criada
- ✅ `app/Models/Domain.php` - Atualizado com workspace_id e relacionamentos

---

## 📌 Notas Finais

- Sistema já tem base sólida com migrations e modelo Workspace
- Maior mudança será no sistema de rotas públicas
- Precisa manter compatibilidade com dados existentes
- Implementação deve ser incremental para evitar quebras
