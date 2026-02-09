# 🚀 Projeto MERE - Guia Consolidado

Este documento centraliza todas as informações importantes, funcionalidades implementadas e procedimentos técnicos do ecossistema MERE.

---

## 🌐 1. Infraestrutura e Acesso

### 🔑 VPS (Servidor de Produção)

- **IP:** `76.13.168.33`
- **Usuário:** `root`
- **Senha:** `Mere-887521.`
- **Diretório:** `/var/www/adminmere`

### 🐙 Repositórios Git

- **Painel Administrativo (Laravel):** `https://github.com/webkennyroger/adminmere.git`
- **App Mobile (Flutter):** `https://github.com/webkennyroger/mere.git`

---

## 🛠️ 2. Workflow de Deploy e Sincronização

### No Computador Local:

```powershell
git add .
git commit -m "Descrição das melhorias"
git push origin main
```

### Na VPS (Sincronizar Produção):

```bash
ssh root@76.13.168.33
cd /var/www/adminmere
git pull origin main
composer install
npm install
npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan boost:update
```

---

## ✅ 3. Funcionalidades Implementadas (Status)

### 🖥️ Painel Web / Backend (Laravel)

- **API Full**: Endpoints para Autenticação, Atividades, Social, Chat, Estatísticas e Assinaturas.
- **Sistema de Nicknames**: Nicknames únicos (`@usuario`) e URLs consistentes.
- **Gestão de Suporte**: Sistema de tickets funcional (Abrir, Listar, Responder).
- **Calendário/Agenda**: Gerenciamento de eventos com localização em PT-BR.
- **Refatoração Core**: Separação de Enquetes/Posts do controlador de atividades.
- **IDE Autocomplete**: Configuração do Laravel Boost para melhor desenvolvimento.

### 📱 App Mobile (Flutter)

- **Onboarding Flow**: Sincronização de dados iniciais (altura, peso, idade, gênero) com o backend.
- **Feed Social**: Listagem de atividades e interações.
- **Navegação**: Fluxo entre feed pessoal e rede de seguidores.
- **Integração API**: Consumo de endpoints autenticados via JWT/Sanctum.

---

## 🔧 4. Notas Técnicas Recentes

1.  **Correção de Erros de Sintaxe**: O arquivo `vendor\_laravel_ide\_model_helpers.php` foi corrigido após ser corrompido por quedas de conexão durante o sync.
2.  **Sincronização de Banco**: Local e VPS estão com as migrações em dia (incluindo tabelas de Enquetes e campos obrigatórios de Posts).
3.  **Vite/Tailwind v4**: Sempre rodar `npm run build` na VPS para carregar o CSS corretamente.

---

## 🎯 5. Próximos Passos

- Implementar validação de nickname único no `UserController.php`.
- Refinar tela de detalhes de atividade no App Mobile.
- Configurar Laravel Echo para notificações em tempo real.
