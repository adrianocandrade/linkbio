# LinkBioTop - Documentação do Projeto

## 🚀 Visão Geral

Projeto de bio-links (SaaS) com funcionalidades de blog, documentação, e páginas personalizáveis.

## 🛠 Atividades Recentes e Correções

### 1. Página Discover (`/discover`)

- **Correção:** A página `/discover` estava vazia.
- **Solução:** Foi corrigida a lógica de filtragem para exibir páginas públicas corretamente e garantir que a paginação funcione.
- **Detalhes:** Agora exibe cards com título, descrição e thumbnail das páginas dos usuários.

### 2. Documentação (`/docs`)

- **Seeders:** Criado e executado `DocsTableSeeder` para popular categorias e guias iniciais.
- **Conteúdo:** Adicionado conteúdo real para "Começando", "Conta", "Faturamento" e "Segurança".
- **Correção de Exibição:** Ajustado o problema onde descrições vazias quebravam o layout.

### 3. Blog (`/blog`)

- **Seeders:** Implementado `BlogTableSeeder` com 10 postagens iniciais sobre marketing e creator economy.
- **Upload de Imagens:**
  - Corrigida validação para aceitar arquivos `.jpeg` (além de `.jpg`) em todos os uploads.
  - Adicionado suporte a `.webp` no upload de thumbnails do blog e ícones PWA.
- **Slug Automático:** Implementado script para gerar URL amigável (slug) automaticamente ao digitar o título do post.

### 4. Outras Correções

- **Captcha:** Configurado preset 'sandy' explicitamente em `config/captcha.php`.
- **Links Externos:** Removidos links de suporte externo (sandydev) para manter white-label.
- **Banco de Dados:** Corrigida coluna `postedBy` e `position` nas tabelas relacionadas.

---

## 📦 Comandos de Produção e Deploy

### Script de Atualização Automática (Recomendado)

Para facilitar o deploy e atualização em produção, foi criado o script `update_project.sh`. Ele executa git pull, instalação de dependências, migrações, seeds e limpeza de cache.

```bash
# Na raiz do projeto no servidor:
sh update_project.sh
```

### Comandos Manuais Importantes

#### 1. Instalação e Atualização

```bash
# Baixar alterações
git pull origin main

# Instalar dependências PHP
composer install --optimize-autoloader --no-dev

# Rodar Migrations (sem perder dados)
php artisan migrate --force
```

#### 2. Popular Banco de Dados (Seeders)

Se precisar popular o banco com os novos dados de Blog e Docs:

```bash
# Popular TUDO (Cuidado: pode duplicar se não tiver verificação)
php artisan db:seed --force

# Popular apenas Blog (seguro, verifica duplicação)
php artisan db:seed --class="Database\Seeders\BlogTableSeeder" --force

# Popular apenas Docs (seguro)
php artisan db:seed --class="Database\Seeders\DocsTableSeeder" --force
```

**Nota:** O seeder principal `DatabaseSeeder` foi atualizado para chamar os seeders específicos automaticamente.

#### 3. Limpeza de Cache (Essencial após alterações de código/config)

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### 4. Logs e Debug

```bash
# Ver logs em tempo real
tail -f storage/logs/laravel.log
```

---

## 📝 Notas Adicionais para o Admin

- **Validação de Imagens:** Se tiver problemas com upload, verifique se o arquivo é `jpg`, `jpeg`, `png`, `webp` ou `svg` e se tem menos de 2MB.
- **Slugs:** Os slugs do blog são gerados automaticamente, mas podem ser editados manualmente se necessário (apenas letras, números e hífens).
