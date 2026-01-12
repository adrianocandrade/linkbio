# 🔒 Análise de Segurança - Sistema de Workspaces

**Data:** 2025-01-XX  
**Analista:** Security Engineer  
**Escopo:** Sistema de Workspaces - Implementação Completa

---

## 📊 Resumo Executivo

### Pontos Positivos ✅

- Rotas protegidas por middleware `auth` e `needActivation`
- Validação de propriedade implementada na maioria dos controllers
- CSRF protection ativo via Laravel middleware
- Isolamento de dados por workspace_id

### Vulnerabilidades Identificadas ⚠️

- **ALTO:** Validação de propriedade inconsistente
- **MÉDIO:** Dependência de sessão manipulável
- **MÉDIO:** Falta de rate limiting
- **MÉDIO:** Validação de entrada insuficiente
- **BAIXO:** Informações expostas em URLs

---

## 🚨 Vulnerabilidades Críticas (ALTO)

### 1. IDOR (Insecure Direct Object Reference) - WorkspaceController

**Severidade:** 🔴 ALTA  
**Localização:** `extension/Mix/Http/Controllers/WorkspaceController.php`

#### Problema:

```php
// ❌ VULNERÁVEL - Linha 68-69
public function switch($id) {
    $workspace = Workspace::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
    session(['active_workspace_id' => $workspace->id]);
    return redirect()->back()->with('success', __('Switched to workspace: ') . $workspace->name);
}
```

**Análise:**

- ✅ Valida propriedade corretamente (`where('user_id', Auth::id())`)
- ⚠️ **PROBLEMA:** Se workspace não existir, `firstOrFail()` retorna 404, mas não valida se usuário tem permissão
- ⚠️ **PROBLEMA:** Não verifica se workspace está ativa (`status = 1`)

#### Risco:

- Usuário pode descobrir IDs de workspaces de outros usuários através de enumeração
- Se workspace for desativada mas ainda existir, pode ser acessada

#### Correção Recomendada:

```php
public function switch($id) {
    // Validar que ID é numérico
    if (!is_numeric($id)) {
        abort(404);
    }

    $workspace = Workspace::where('id', $id)
        ->where('user_id', Auth::id())
        ->where('status', 1) // ✅ Adicionar verificação de status
        ->first();

    if (!$workspace) {
        abort(404, __('Workspace not found or you do not have permission to access it.'));
    }

    session(['active_workspace_id' => $workspace->id]);

    return redirect()->back()->with('success', __('Switched to workspace: ') . $workspace->name);
}
```

---

### 2. Falta de Validação de Status da Workspace

**Severidade:** 🔴 ALTA  
**Localização:** Múltiplos controllers

#### Problema:

- Workspaces podem estar inativas (`status = 0`)
- Sistema não valida status ao acessar workspace em contexto autenticado
- Usuário pode acessar workspace desativada se souber o ID

#### Ocorrências:

- `WorkspaceController@switch()` - não verifica status
- `WorkspaceController@edit()` - não verifica status
- `WorkspaceController@update()` - não verifica status

#### Correção:

Adicionar validação de status em todos os métodos que acessam workspace:

```php
$workspace = Workspace::where('id', $id)
    ->where('user_id', Auth::id())
    ->where('status', 1) // ✅ Adicionar esta linha
    ->firstOrFail();
```

---

### 3. Session Hijacking / Manipulação de Sessão

**Severidade:** 🟠 MÉDIA-ALTA  
**Localização:** Múltiplos pontos

#### Problema:

```php
// ❌ VULNERÁVEL - Dependência de sessão manipulável
$workspaceId = session('active_workspace_id');

// Se usuário conseguir injetar na sessão, pode acessar workspaces de outros
```

#### Riscos:

1. **Session Fixation:** Atacante pode fixar session ID e forçar vítima a usar
2. **Session Prediction:** Se session ID for previsível
3. **Cross-Site Scripting (XSS):** Roubo de cookie de sessão

#### Mitigações Existentes:

- ✅ Laravel usa cookies httpOnly por padrão
- ✅ Session regenerado no login
- ⚠️ **FALTA:** Validação adicional ao usar workspace_id da sessão

#### Correção Recomendada:

Sempre validar que workspace da sessão pertence ao usuário autenticado:

```php
public function index(Request $request){
    $workspaceId = session('active_workspace_id');

    // ✅ Sempre validar propriedade ao usar da sessão
    if ($workspaceId) {
        $workspace = \App\Models\Workspace::where('id', $workspaceId)
            ->where('user_id', $this->user->id)
            ->where('status', 1)
            ->first();

        if (!$workspace) {
            // Workspace inválida na sessão, resetar
            session()->forget('active_workspace_id');
            $workspaceId = null;
        }
    }

    // ... resto do código
}
```

---

## ⚠️ Vulnerabilidades Médias

### 4. Validação de Slug Insuficiente

**Severidade:** 🟠 MÉDIA  
**Localização:** `WorkspaceController@store`, `WorkspaceController@update`

#### Problema:

```php
$request->validate([
    'slug' => 'required|string|max:255|unique:workspaces,slug|alpha_dash',
]);
```

**Análise:**

- ✅ `alpha_dash` valida formato básico
- ⚠️ **PROBLEMA:** Permite slugs que podem ser confundidos com rotas do sistema
- ⚠️ **PROBLEMA:** Não bloqueia palavras reservadas (`admin`, `api`, `auth`, etc.)
- ⚠️ **PROBLEMA:** Não valida comprimento mínimo

#### Riscos:

- Slug pode conflitar com rotas do sistema
- Slug pode ser muito curto (1 caractere)
- Slug pode ser muito longo (255 caracteres)

#### Correção Recomendada:

```php
$request->validate([
    'name' => 'required|string|max:255',
    'slug' => [
        'required',
        'string',
        'min:3',
        'max:50',
        'alpha_dash',
        'unique:workspaces,slug',
        'not_in:admin,api,auth,mix,settings,workspace,create,edit,delete,switch,store,update', // Palavras reservadas
        'regex:/^[a-z0-9-]+$/' // Apenas lowercase, números e hífen
    ],
]);
```

---

### 5. Falta de Rate Limiting

**Severidade:** 🟠 MÉDIA  
**Localização:** Rotas de workspace

#### Problema:

- Nenhum rate limiting nas rotas de criação/edição de workspace
- Atacante pode criar muitas workspaces para testar limites
- Possível DoS através de criação massiva

#### Correção Recomendada:

Adicionar rate limiting nas rotas:

```php
// Em extension/Mix/Routes/web.php
Route::group(['middleware' => ['auth', 'needActivation', 'throttle:10,1'], 'prefix' => 'mix'], function(){
    // Rotas de workspace
    Route::group(['prefix' => 'workspace'], function(){
        Route::post('store', 'WorkspaceController@store')
            ->middleware('throttle:5,1'); // 5 tentativas por minuto
        Route::post('update/{id}', 'WorkspaceController@update')
            ->middleware('throttle:10,1');
        Route::post('delete/{id}', 'WorkspaceController@delete')
            ->middleware('throttle:5,1');
    });
});
```

---

### 6. Race Condition na Validação de Limite

**Severidade:** 🟠 MÉDIA  
**Localização:** `WorkspaceController@store`

#### Problema:

```php
// ❌ Race condition possível
$workspaceCount = $user->workspaces()->count();
if ($workspaceCount >= $limit) {
    return back()->with('error', ...);
}
// Entre essas linhas, outro request pode criar workspace
$workspace->save();
```

#### Risco:

- Usuário pode fazer múltiplas requisições simultâneas
- Todas passam na validação antes de salvar
- Limite pode ser excedido

#### Correção:

Usar transação com lock:

```php
\DB::transaction(function() use ($user, $limit, $request) {
    // Lock na contagem
    $workspaceCount = $user->workspaces()->lockForUpdate()->count();

    if ($workspaceCount >= $limit) {
        throw new \Exception(__('Limit reached'));
    }

    // Criar workspace
    $workspace = new Workspace();
    // ... resto do código
    $workspace->save();
});
```

---

### 7. Informação Sensível em URLs

**Severidade:** 🟡 BAIXA-MÉDIA  
**Localização:** Rotas públicas

#### Problema:

- IDs de workspace podem ser expostos em URLs
- Enumeração de IDs pode revelar informações sobre sistema

#### Exemplo:

```
/mix/workspace/edit/123
/mix/workspace/switch/456
```

#### Mitigação:

✅ Já implementado: Sistema usa slug em vez de ID para rotas públicas  
⚠️ **PROBLEMA:** Rotas administrativas ainda usam ID

#### Recomendação:

- Para rotas administrativas, considerar usar UUID em vez de ID incremental
- Ou adicionar hash/token único para cada workspace

---

## 🔍 Vulnerabilidades Baixas

### 8. Falta de Logging de Ações Sensíveis

**Severidade:** 🟡 BAIXA  
**Localização:** `WorkspaceController`

#### Problema:

- Ações sensíveis (criação, edição, deleção de workspace) não são logadas
- Dificulta auditoria e detecção de atividades suspeitas

#### Correção:

```php
public function store(Request $request) {
    // ... código existente

    $workspace->save();

    // ✅ Adicionar logging
    \Log::info('Workspace created', [
        'user_id' => $user->id,
        'workspace_id' => $workspace->id,
        'workspace_slug' => $workspace->slug,
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent()
    ]);

    // ... resto do código
}
```

---

### 9. Validação de Entrada - XSS Potencial

**Severidade:** 🟡 BAIXA  
**Localização:** Views e Controllers

#### Análise:

- ✅ Laravel escapa automaticamente variáveis em Blade (`{{ }}`)
- ✅ Validation sanitiza entrada
- ⚠️ **VERIFICAR:** Se há uso de `{!! !!}` sem sanitização em views de workspace

#### Recomendação:

Auditar todas as views de workspace para garantir que dados do usuário sejam escapados.

---

### 10. SQL Injection

**Severidade:** 🟢 MUITO BAIXA  
**Status:** ✅ PROTEGIDO

#### Análise:

- ✅ Uso de Eloquent ORM previne SQL Injection
- ✅ Query Builder usa prepared statements
- ✅ Validação de entrada implementada

**Veredicto:** Sistema protegido contra SQL Injection.

---

## 🔐 Boas Práticas de Segurança Implementadas

### ✅ Pontos Positivos

1. **Autenticação:**

   - Middleware `auth` em todas as rotas de workspace
   - Middleware `needActivation` para usuários ativados

2. **Autorização:**

   - Validação de propriedade: `where('user_id', Auth::id())`
   - Proteção da primeira workspace

3. **CSRF Protection:**

   - Laravel VerifyCsrfToken middleware ativo
   - Tokens validados em formulários

4. **Validação:**

   - Laravel Validation implementada
   - Validação de slug único

5. **Isolamento de Dados:**
   - Filtros por workspace_id implementados
   - Queries filtradas corretamente

---

## 📋 Checklist de Segurança

### Autenticação e Autorização

- [x] Middleware auth nas rotas
- [x] Validação de propriedade (user_id)
- [ ] ⚠️ Validação de status da workspace
- [ ] ⚠️ Validação adicional ao usar session

### Validação de Entrada

- [x] Validação de dados de entrada
- [x] Sanitização de slug (alpha_dash)
- [ ] ⚠️ Lista de palavras reservadas
- [ ] ⚠️ Comprimento mínimo/máximo
- [ ] ⚠️ Regex mais restritivo

### Rate Limiting

- [ ] ⚠️ Rate limiting em criação
- [ ] ⚠️ Rate limiting em edição
- [ ] ⚠️ Rate limiting em deleção

### Logging e Auditoria

- [ ] ⚠️ Log de ações sensíveis
- [ ] ⚠️ Log de tentativas falhas
- [ ] ⚠️ Log de mudanças de workspace

### Proteção de Sessão

- [x] Cookies httpOnly
- [x] CSRF tokens
- [ ] ⚠️ Validação de workspace da sessão
- [ ] ⚠️ Timeout de sessão configurado

### Isolamento de Dados

- [x] Filtros por workspace_id
- [x] Queries isoladas
- [ ] ⚠️ Verificar todos os pontos de acesso

---

## 🛠️ Recomendações de Implementação (Prioridade)

### 🔴 CRÍTICO - Implementar Imediatamente

1. **Adicionar validação de status em WorkspaceController**

   ```php
   ->where('status', 1)
   ```

2. **Validar workspace da sessão em MixController**

   - Sempre verificar que workspace pertence ao usuário
   - Resetar sessão se inválida

3. **Corrigir race condition no limite**
   - Usar transação com lock

### 🟠 ALTO - Implementar em Breve

4. **Melhorar validação de slug**

   - Adicionar palavras reservadas
   - Regex mais restritivo
   - Comprimento mínimo

5. **Adicionar rate limiting**

   - Limitar criação/edição/deleção

6. **Adicionar logging**
   - Log de ações sensíveis
   - Log de tentativas falhas

### 🟡 MÉDIO - Melhorias Futuras

7. **Considerar UUID em vez de ID**

   - Para rotas administrativas

8. **Adicionar monitoramento**

   - Alertas para atividades suspeitas
   - Dashboard de segurança

9. **Implementar 2FA**
   - Para ações sensíveis (deleção de workspace)

---

## 📝 Código de Correção Completo

### WorkspaceController - Versão Segura

```php
<?php

namespace Modules\Mix\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Workspace;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WorkspaceController extends Controller
{
    // Palavras reservadas que não podem ser usadas como slug
    protected $reservedSlugs = [
        'admin', 'api', 'auth', 'mix', 'settings', 'workspace',
        'create', 'edit', 'delete', 'switch', 'store', 'update',
        'index', 'home', 'login', 'register', 'logout'
    ];

    public function create() {
        $user = Auth::user();
        return view('mix::workspace.create', compact('user'));
    }

    public function store(Request $request) {
        $user = Auth::user();

        // Validação melhorada
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                'unique:workspaces,slug',
                'not_in:' . implode(',', $this->reservedSlugs),
                'regex:/^[a-z0-9-]+$/'
            ],
        ]);

        // Normalizar slug (lowercase)
        $slug = strtolower($request->slug);

        // Transação com lock para evitar race condition
        try {
            DB::beginTransaction();

            // Check Plan Limits com lock
            $plan = Plan::find($user->plan);

            $limit = 1;
            if ($plan && isset($plan->settings['workspaces_limit'])) {
                $limit = (int) $plan->settings['workspaces_limit'];
            }

            // Lock para evitar race condition
            $workspaceCount = $user->workspaces()
                ->lockForUpdate()
                ->where('status', 1)
                ->count();

            if ($workspaceCount >= $limit) {
                DB::rollBack();
                return back()->with('error', __('You have reached the maximum number of workspaces allowed by your plan. Limit: :limit', ['limit' => $limit]));
            }

            // Criar workspace
            $defaultWorkspace = $user->workspaces()->where('is_default', 1)->first();

            $workspace = new Workspace();
            $workspace->user_id = $user->id;
            $workspace->name = $request->name;
            $workspace->slug = $slug;
            $workspace->status = 1;

            if ($defaultWorkspace) {
                $workspace->theme = $defaultWorkspace->theme;
                $workspace->font = $defaultWorkspace->font;
            }

            $workspace->save();

            DB::commit();

            // Logging
            Log::info('Workspace created', [
                'user_id' => $user->id,
                'workspace_id' => $workspace->id,
                'workspace_slug' => $workspace->slug,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Switch to new workspace
            session(['active_workspace_id' => $workspace->id]);

            return redirect()->route('user-mix')->with('success', __('Workspace created successfully.'));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Workspace creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->with('error', __('An error occurred. Please try again.'));
        }
    }

    public function switch($id) {
        // Validar ID
        if (!is_numeric($id)) {
            abort(404);
        }

        $workspace = Workspace::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 1) // ✅ Verificar status
            ->first();

        if (!$workspace) {
            Log::warning('Workspace switch attempt failed', [
                'user_id' => Auth::id(),
                'workspace_id' => $id,
                'ip' => request()->ip()
            ]);
            abort(404, __('Workspace not found or you do not have permission to access it.'));
        }

        session(['active_workspace_id' => $workspace->id]);

        Log::info('Workspace switched', [
            'user_id' => Auth::id(),
            'workspace_id' => $workspace->id,
            'ip' => request()->ip()
        ]);

        return redirect()->back()->with('success', __('Switched to workspace: ') . $workspace->name);
    }

    public function edit($id) {
        if (!is_numeric($id)) {
            abort(404);
        }

        $user = Auth::user();
        $workspace = Workspace::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 1) // ✅ Verificar status
            ->firstOrFail();

        return view('mix::workspace.edit', compact('user', 'workspace'));
    }

    public function update(Request $request, $id) {
        if (!is_numeric($id)) {
            abort(404);
        }

        $user = Auth::user();
        $workspace = Workspace::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 1) // ✅ Verificar status
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                'unique:workspaces,slug,'.$workspace->id,
                'not_in:' . implode(',', $this->reservedSlugs),
                'regex:/^[a-z0-9-]+$/'
            ],
        ]);

        $oldSlug = $workspace->slug;
        $workspace->name = $request->name;
        $workspace->slug = strtolower($request->slug);
        $workspace->save();

        Log::info('Workspace updated', [
            'user_id' => $user->id,
            'workspace_id' => $workspace->id,
            'old_slug' => $oldSlug,
            'new_slug' => $workspace->slug,
            'ip' => $request->ip()
        ]);

        return back()->with('success', __('Workspace updated successfully.'));
    }

    public function delete($id) {
        if (!is_numeric($id)) {
            abort(404);
        }

        $user = Auth::user();
        $workspace = Workspace::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->firstOrFail();

        // Protect: Cannot delete the first/default workspace
        if ($workspace->is_default == 1) {
            return back()->with('error', __('You cannot delete your main workspace. This workspace is permanently linked to your account.'));
        }

        // Double check: if it's the oldest workspace, also protect it
        $firstWorkspace = Workspace::where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->first();

        if ($workspace->id === $firstWorkspace->id) {
            return back()->with('error', __('You cannot delete your main workspace. This workspace is permanently linked to your account.'));
        }

        // Backup antes de deletar
        self::processDeletion($workspace);

        // Logging
        Log::warning('Workspace deleted', [
            'user_id' => $user->id,
            'workspace_id' => $workspace->id,
            'workspace_slug' => $workspace->slug,
            'ip' => request()->ip()
        ]);

        // Reset Session if active
        if (session('active_workspace_id') == $id) {
            session()->forget('active_workspace_id');
            $defaultWorkspace = Workspace::where('user_id', $user->id)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            if ($defaultWorkspace) {
                session(['active_workspace_id' => $defaultWorkspace->id]);
            } else {
                $next = Workspace::where('user_id', $user->id)
                    ->where('status', 1)
                    ->first();
                if ($next) {
                    session(['active_workspace_id' => $next->id]);
                }
            }
        }

        return redirect()->route('user-mix')->with('success', __('Workspace deleted successfully.'));
    }

    public static function processDeletion(Workspace $workspace) {
        // Security / Fraud Prevention Backup
        $backupData = $workspace->load('user')->toArray();
        $backupJson = json_encode($backupData, JSON_PRETTY_PRINT);

        // Ensure directory exists
        $path = storage_path('app/backups/workspaces');
        if(!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $filename = 'workspace_backup_' . $workspace->id . '_' . time() . '.json';
        file_put_contents($path . '/' . $filename, $backupJson);

        // Delete
        $workspace->delete();
    }
}
```

---

## 🎯 Conclusão

### Estado Atual

O sistema possui uma base sólida de segurança, mas necessita de melhorias em validações e proteções adicionais.

### Prioridades

1. **Imediato:** Adicionar validação de status e corrigir race condition
2. **Curto Prazo:** Melhorar validação de slug e adicionar rate limiting
3. **Médio Prazo:** Implementar logging e monitoramento

### Score de Segurança

**6.5/10** - Sistema funcional com boas práticas básicas, mas precisa de melhorias em validações e proteções adicionais.

---

## 📚 Referências

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [OWASP IDOR](https://owasp.org/www-community/vulnerabilities/Insecure_Direct_Object_Reference)
- [Laravel Rate Limiting](https://laravel.com/docs/routing#rate-limiting)
