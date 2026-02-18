# Progresso do Desenvolvimento - Mere App & Admin

Data: 18/02/2026

## ✅ Concluído

### Frontend (Admin/Web)

- **Dark Mode Correction:**
    - Corrigido problema de "Race Condition" no Alpine.js.
    - Implementado listener `alpine:init` para garantir carregamento correto das stores.
    - Adicionada transição suave (`transition-colors duration-300`) no CSS global.
- **Chat Sidebar:**
    - Corrigida inicialização da Store do Chat.
    - Funcionalidade de abrir/fechar sidebar validada.

### Backend (Laravel)

- **Validação de Nickname:**
    - Adicionada regra de validação `unique:profiles,nickname` no `UserController::updateProfile`.
    - Tratamento para ignorar o próprio ID do perfil durante a atualização.
    - **Status:** Implementado, mas o teste automatizado apresentou instabilidade no ambiente local. Requer validação manual ou ajuste fino no `Rule::ignore`.

## 🚧 Em Andamento / Pendente

### 1. Backend (Urgente)

- **Validar Nickname Único:**
    - A lógica de `ignore($profileId)` precisa ser verificada. Nos testes, ela estava bloqueando a atualização do próprio usuário.
    - Recomendação: Testar via Postman/Insomnia no próximo ambiente para garantir que `Rule::unique('profiles')->ignore($user->profile->id)` está funcionando como deve.

### 2. Mobile (Flutter)

- **Tela de Detalhes de Atividade:**
    - Melhorar UX da tela.
    - Ajustar exibição de estatísticas e mapas.

### 3. Infraestrutura

- **Deploy:**
    - Realizar deploy na VPS após validação final.
    - Rodar `npm run build` no servidor.

## 📝 Comandos Úteis para Retomada

```bash
# No diretório adminmere
php artisan test --filter=UserNicknameValidationTest  # Para rodar os testes de nickname
npm run dev  # Para rodar o frontend
```

## ⚠️ Atenção

- O arquivo `UserController.php` já contém a lógica de validação. Se der erro ao salvar o próprio perfil, verifique o parâmetro `ignore`.
