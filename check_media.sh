#!/bin/bash
echo "=== Checking last post ==="
cd /var/www/adminmere
php artisan tinker --execute="
\$post = App\Models\Post::latest()->first();
if (\$post) {
    echo 'Post ID: ' . \$post->id . PHP_EOL;
    echo 'Title: ' . \$post->title . PHP_EOL;
    echo 'Media: ' . json_encode(\$post->media) . PHP_EOL;
    echo 'Media count: ' . count(\$post->media ?? []) . PHP_EOL;
} else {
    echo 'No posts found' . PHP_EOL;
}
"

echo ""
echo "=== Checking storage directory ==="
ls -lah /var/www/adminmere/storage/app/public/posts/ | head -20

echo ""
echo "=== Checking public symlink ==="
ls -lah /var/www/adminmere/public/storage
