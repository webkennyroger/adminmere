# GUIA DE TESTE E DIAGNÓSTICO

## Passo 1: Atualizar o servidor

```bash
ssh root@76.13.168.33 "cd /var/www/adminmere && git pull origin main && php artisan optimize:clear && chmod -R 775 storage && chown -R www-data:www-data storage"
```

## Passo 2: Limpar logs antigos

```bash
ssh root@76.13.168.33 "cd /var/www/adminmere && echo '' > storage/logs/laravel.log"
```

## Passo 3: Testar criação de post

1. Acesse: https://kennyroger.com.br/home?feed=personal
2. Clique em "Foto/Vídeo" e selecione 1-2 imagens
3. Escreva algo no campo de texto (ex: "teste")
4. Clique em PUBLICAR
5. Aguarde o reload da página

## Passo 4: Verificar logs

```bash
ssh root@76.13.168.33 "cd /var/www/adminmere && tail -100 storage/logs/laravel.log"
```

## Passo 5: Verificar se o post foi criado

```bash
ssh root@76.13.168.33 "cd /var/www/adminmere && php artisan tinker --execute='echo App\Models\Post::latest()->first()->toJson();'"
```

## O que procurar nos logs:

- "=== SAVE POST STARTED ===" - confirma que o método foi chamado
- "Photos count: X" - quantas fotos foram selecionadas
- "Validation passed" - validação OK
- "Photo X stored: ..." - cada foto foi salva
- "Post created successfully with ID: X" - post foi criado
- Qualquer mensagem de ERRO

## Se aparecer erro de permissão:

```bash
ssh root@76.13.168.33 "cd /var/www/adminmere && sudo chmod -R 775 storage/app/public && sudo chown -R www-data:www-data storage/app/public"
```

## Se o link simbólico não existir:

```bash
ssh root@76.13.168.33 "cd /var/www/adminmere && php artisan storage:link"
```
