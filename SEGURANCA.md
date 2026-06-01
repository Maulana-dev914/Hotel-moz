# Segurança do Sistema - Hotel Moz

## Proteção de Acesso Administrativo

O sistema implementa múltiplas camadas de segurança para garantir que apenas usuários autenticados possam acessar o painel administrativo.

### 1. Middleware de Autenticação (`EnsureAuthenticated`)

- **Localização:** `app/Http/Middleware/EnsureAuthenticated.php`
- **Função:** Verifica se o usuário está autenticado antes de permitir acesso às rotas administrativas
- **Verificações:**
  - Verifica se existe `user_id` na sessão
  - Valida se o usuário ainda existe no banco de dados
  - Redireciona para login se não autenticado
  - Limpa a sessão se o usuário não existir mais

### 2. Proteção de Rotas

Todas as rotas administrativas estão protegidas com o middleware `admin.auth`:

```php
Route::middleware(['admin.auth'])->prefix('admin')->name('admin.')->group(function () {
    // Todas as rotas administrativas aqui
});
```

**Rotas Protegidas:**
- `/admin/dashboard` - Dashboard principal
- `/admin/rooms/*` - Gestão de quartos
- `/admin/guests/*` - Gestão de hóspedes
- `/admin/reservations/*` - Gestão de reservas
- `/admin/stays/*` - Gestão de estadias
- `/admin/reviews/*` - Gestão de avaliações
- `/admin/users/*` - Gestão de usuários
- `/admin/profile/*` - Perfil do usuário
- `/admin/settings` - Definições

**Rotas Públicas (não protegidas):**
- `/admin/login` - Página de login
- `/admin/logout` - Logout
- `/admin/password/forgot` - Recuperação de senha
- `/admin/password/reset` - Redefinição de senha

### 3. Sistema de Login

- **Validação de Credenciais:** Email e senha são obrigatórios
- **Verificação de Hash:** Senhas são verificadas usando `Hash::check()`
- **Limpeza de Sessão:** Sessão anterior é invalidada antes de criar nova
- **Regeneração de Token:** Token CSRF é regenerado após login
- **Mensagens de Erro:** Mensagens claras em caso de credenciais inválidas

### 4. Sistema de Logout

- **Limpeza Completa:** Todas as variáveis de sessão são removidas
- **Invalidação:** Sessão é invalidada
- **Regeneração:** Token CSRF é regenerado
- **Redirecionamento:** Usuário é redirecionado para página de login

### 5. Proteção Adicional

- **Rota Fallback:** Qualquer tentativa de acessar `/admin/*` sem autenticação é redirecionada
- **Verificação no Controller:** DashboardController verifica autenticação adicional
- **Proteção de Recuperação de Senha:** Redireciona usuários já logados

### 6. Sessão e Segurança

- **Armazenamento:** Dados de autenticação armazenados na sessão
- **Validação Contínua:** Middleware valida autenticação em cada requisição
- **Expiração:** Sessão é limpa se usuário não existir mais no banco

## Como Funciona

1. **Tentativa de Acesso:**
   - Usuário tenta acessar rota administrativa
   - Middleware `admin.auth` intercepta a requisição

2. **Verificação:**
   - Verifica se `user_id` existe na sessão
   - Verifica se o usuário existe no banco de dados

3. **Ação:**
   - Se autenticado: Permite acesso
   - Se não autenticado: Redireciona para `/admin/login`

4. **Login:**
   - Usuário fornece email e senha
   - Sistema valida credenciais
   - Se válidas: Cria sessão e redireciona para dashboard
   - Se inválidas: Mostra erro e mantém na página de login

## Credenciais Padrão

Ver arquivo `CREDENCIAIS.md` para informações sobre credenciais de acesso.

## Recomendações de Segurança

1. **Alterar Senhas Padrão:** Altere as senhas após primeiro acesso
2. **Usar Senhas Fortes:** Mínimo de 8 caracteres, incluindo letras, números e símbolos
3. **Logout Seguro:** Sempre faça logout ao terminar de usar o sistema
4. **Sessões:** Não compartilhe sessões entre dispositivos
5. **HTTPS:** Use HTTPS em produção para proteger dados em trânsito


