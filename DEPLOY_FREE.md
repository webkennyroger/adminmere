# Deploy Gratuito do Laravel (AdminMere)

Este guia explica como hospedar este painel administrativo gratuitamente usando **Render.com** (Aplicação) e **Neon.tech** (Banco de Dados PostgreSQL).

## 1. Banco de Dados Gratuito (Neon ou Supabase)

O Render cobra pelo banco de dados após 90 dias, então recomendamos usar um serviço externo gratuito para o PostgreSQL.

**Opção A: Neon.tech (Recomendado)**

1. Crie uma conta no [Neon.tech](https://neon.tech).
2. Crie um novo projeto.
3. Copie os dados de host, user, password e database.

**Opção B: Supabase (Você escolheu esta)**

1. Acesse seu projeto no [Supabase](https://supabase.com).
2. Vá em **Settings** (ícone de engrenagem) -> **Database**.
3. Em "Connection parameters", você verá:
    - **Host:** `db.xxxxxxxx.supabase.co`
    - **Database:** `postgres`
    - **User:** `postgres`
    - **Password:** (A senha que você criou ao iniciar o projeto. Se esqueceu, pode resetar nessa mesma tela).
    - **Port:** `5432` (Use a porta 5432 para conexão direta e 6543 se usar o pooler).

Guardar esses dados para o passo 3.

## 2. Preparar o Código

O projeto já contém um `Dockerfile` configurado para produção.

1. Crie um repositório no **GitHub** (pode ser privado).
2. Envie seu código para lá:
    ```bash
    git add .
    git commit -m "Configuração de deploy"
    git data-remote add origin SEU_REPO_URL
    git push -u origin main
    ```

## 3. Hospedagem no Render (App)

1. Crie uma conta no [Render.com](https://render.com).
2. Clique em **New +** -> **Web Service**.
3. Conecte sua conta do GitHub e selecione o repositório do `adminmere`.
4. Configurações:
    - **Name:** adminmere
    - **Region:** Ohio (US East) ou Frankfurt (EU) - escolha a mais próxima do seu banco de dados.
    - **Branch:** main
    - **Runtime:** **Docker** (O Render vai detectar o Dockerfile automaticamente).
    - **Instance Type:** Free

5. **Variáveis de Ambiente (Environment Variables)**:
   Adicione as seguintes chaves (copie do seu `.env` local, mas ajuste para produção):

    | Chave           | Valor Exemplo                                                             |
    | --------------- | ------------------------------------------------------------------------- |
    | `APP_Key`       | (Gere uma nova com `php artisan key:generate --show` localmente)          |
    | `APP_DEBUG`     | `false`                                                                   |
    | `APP_ENV`       | `production`                                                              |
    | `APP_URL`       | `https://adminmere.onrender.com` (o Render vai te dar a URL final depois) |
    | `LOG_CHANNEL`   | `stderr` (Importante para ver logs no painel do Render)                   |
    | `DB_CONNECTION` | `pgsql`                                                                   |
    | `DATABASE_URL`  | (Cole a string de conexão do Neon aqui)                                   |
    | `DB_HOST`       | (Extraído do Neon - ex: ep-xyz.aws.neon.tech)                             |
    | `DB_PORT`       | `5432`                                                                    |
    | `DB_DATABASE`   | `neondb` (ou o nome que estiver no Neon)                                  |
    | `DB_USERNAME`   | (Extraído do Neon)                                                        |
    | `DB_PASSWORD`   | (Extraído do Neon)                                                        |
    | `ASSET_URL`     | (Deixe vazio ou use a URL do Render se tiver problemas com imagens)       |

    > **Dica:** O Laravel suporta a variável `DATABASE_URL` diretamente se você configurar o `config/database.php` para ler ela, mas por padrão ele usa DB_HOST, DB_USERNAME, etc. O jeito mais fácil é preencher DB_HOST, DB_PORT, etc. separadamente com os dados do Neon.

6. Clique em **Create Web Service**.

## 4. Finalização

O Render vai iniciar o build (pode levar uns 5-10 minutos na primeira vez para baixar o Docker).
Assim que terminar, ele vai rodar o comando de entrada (`entrypoint.sh`) que automaticamente executa `php artisan migrate --force` para criar as tabelas no seu banco Neon.

Pronto! Seu admin estará online.

### Observações sobre o Plano Free do Render

- A aplicação "dorme" após 15 minutos de inatividade. O primeiro acesso depois disso pode levar uns 30 segundos para carregar.
- Para evitar isso, você pode usar um serviço de "Cron Job" externo (como cron-job.org) para pingar seu site a cada 10 minutos.

### Armazenamento de Arquivos/Imagens

O sistema de arquivos do Render é **temporário**. Se você fizer upload de uma imagem no admin, ela vai sumir na próxima vez que o site reiniciar.

- **Solução Gratuita:** Crie uma conta no **Cloudinary** e instale o pacote `cloudinary-labs/cloudinary-laravel`. Configure para que os uploads vão para lá.
- Ou use o Driver **S3** com um bucket AWS (Free tier 1 ano) ou Cloudflare R2 (Barato).
