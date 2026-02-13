#!/bin/bash

echo "=== DIAGNÓSTICO DO SISTEMA DE POSTS ==="
echo ""

cd /var/www/adminmere

echo "1. Verificando permissões de storage..."
ls -la storage/app/public/posts 2>&1 || echo "Pasta posts não existe"

echo ""
echo "2. Verificando últimos 3 posts no banco..."
php artisan tinker --execute="
\$posts = App\Models\Post::latest()->take(3)->get();
foreach(\$posts as \$p) {
    echo 'ID: ' . \$p->id . ' | User: ' . \$p->user_id . ' | Privacy: ' . \$p->privacy . ' | Media: ' . json_encode(\$p->media) . PHP_EOL;
}
"

echo ""
echo "3. Verificando link simbólico do storage..."
ls -la public/storage

echo ""
echo "4. Testando criação de post..."
php artisan tinker --execute="
try {
    \$post = App\Models\Post::create([
        'user_id' => 1,
        'content' => 'Teste de diagnóstico',
        'privacy' => 'public',
        'type' => 'post',
        'feed_type' => 'personal'
    ]);
    echo 'Post criado com sucesso! ID: ' . \$post->id . PHP_EOL;
} catch (Exception \$e) {
    echo 'ERRO: ' . \$e->getMessage() . PHP_EOL;
}
"

echo ""
echo "5. Verificando APP_URL no .env..."
grep APP_URL .env

echo ""
echo "=== FIM DO DIAGNÓSTICO ==="
