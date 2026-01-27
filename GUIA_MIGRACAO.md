# Guia de Migração: VPS -> Git -> Local

Como eu não tenho acesso direto à senha do seu VPS, você precisará executar alguns comandos simples no terminal do seu servidor para enviar o código para o GitHub.

## Passo 1: Acessar o VPS

Use seu terminal (PowerShell, CMD ou Terminal do VS Code) para acessar o VPS usando a senha que você tem no painel:

```bash
ssh root@76.13.168.33
```

_(Digite a senha quando pedir)_

## Passo 2: Encontrar e Enviar o Site para o Git (No VPS)

Uma vez conectado no VPS, execute estes comandos um por um.

**Importante:** Você precisa saber onde o site está instalado. Geralmente é `/var/www/html` ou `/var/www/seu-site`.
Vamos assumir que é `/var/www/kennyroger` (ou html). Tente listar para achar:

```bash
ls /var/www/
```

Quando encontrar a pasta correta, entre nela:

```bash
cd /var/www/NOME_DA_PASTA
```

Agora, vamos transformar essa pasta em um repositório Git e enviar para o seu GitHub.
_Substitua `URL_DO_SEU_NOVO_REPO` pelo link do repositório vazio que você criou no GitHub._

```bash
# Iniciar git
git init
git branch -M main

# Configurar seu usuário (opcional, mas bom pra histórico)
git config user.name "Seu Nome"
git config user.email "seu@email.com"

# Adicionar todos os arquivos
git add .
git commit -m "Backup versão VPS"

# Adicionar o repositório remoto e enviar
# Exemplo: https://github.com/webkennyroger/adminmere.git
git remote add origin URL_DO_SEU_NOVO_REPO
git push -u origin main
```

_(Pode ser que ele peça usuário e "token" (senha) do GitHub. Se você não tiver um token configurado no VPS, pode ser mais fácil baixar os arquivos via SCP, veja abaixo)_

---

## Alternativa: Baixar Direto para sua Máquina (Sem Git no VPS)

Se você achar complicado configurar o Git dentro do VPS, podemos baixar os arquivos direto para sua máquina Windows usando o comando `scp`.

**Execute isso NO SEU COMPUTADOR (PowerShell do VS Code), e não no VPS:**

```powershell
# Cria a pasta se não existir
mkdir -p c:\Users\Defensoria\Herd\adminmere

# Baixa tudo da pasta /var/www/adminmere (pasta correta encontrada)
scp -r root@76.13.168.33:/var/www/adminmere/* c:\Users\Defensoria\Herd\adminmere\
```

_(Ele vai pedir a senha do root e começar a baixar os arquivos)_

Depois que baixar, nós conectamos ao Git daqui da sua máquina, que é mais fácil.

## Qual opção você prefere?

1. **Via Git no VPS**: Melhor se você já tem chaves SSH configuradas.
2. **Via Download Direto (SCP)**: Mais fácil se você só tem a senha.
