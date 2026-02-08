# 🌐 Guia de Acesso e Deploy - MERE

Este documento contém as credenciais e os comandos necessários para gerenciar o servidor (VPS) e o sincronismo com o Git.

---

### 🔑 Credenciais da VPS

- **IP:** `76.13.168.33`
- **Usuário:** `root`
- **Senha:** `Mere-887521.` (Nota: O ponto final faz parte da senha)
- **Diretório do Projeto:** `/var/www/adminmere`

### 🐙 Repositórios Git

- **App Mobile (Flutter):** `https://github.com/webkennyroger/mere.git`
- **Painel Administrativo (Laravel):** `https://github.com/webkennyroger/adminmere.git`

---

### 🚀 Fluxo de Trabalho (Workflow)

#### 1. Enviar alterações do seu computador para o Git

Sempre faça isso antes de subir para a VPS.

```bash
git add .
git commit -m "Descrição das melhorias"
git push origin main
```

#### 2. Atualizar a VPS (Subir do Git para o Servidor)

Acesse a VPS via SSH e rode os comandos de atualização:

**Acessar o servidor:**

```bash
ssh root@76.13.168.33
# Digite a senha quando solicitado
```

**Comandos de Deploy (dentro da VPS):**

```bash
cd /var/www/adminmere

# Baixar o código novo do Git
git pull origin main

# Atualizar dependências (se houver novos pacotes)
composer install
npm install

# GERAR O CSS/JS (Crucial para o Tailwind CSS carregar)
npm run build

# Atualizar banco de dados e limpar cache
php artisan migrate --force
php artisan optimize:clear
```

---

### 🛠️ Problemas Comuns

- **Tailwind não aparece na VPS:** Certifique-se de rodar `npm run build` dentro da VPS. No Tailwind v4, ele não carrega sem esse comando.
- **Permissão de Pasta:** Se as imagens não carregarem, rode `chown -R www-data:www-data storage bootstrap/cache`.
