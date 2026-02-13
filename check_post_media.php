<?php
// Quick check of the last post's media
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$post = App\Models\Post::latest()->first();

if ($post) {
    echo "Post ID: {$post->id}\n";
    echo "Title: {$post->title}\n";
    echo "Media (raw): " . var_export($post->getAttributes()['media'], true) . "\n";
    echo "Media (cast): " . var_export($post->media, true) . "\n";
    echo "Media count: " . count($post->media ?? []) . "\n";

    if ($post->media) {
        foreach ($post->media as $index => $url) {
            echo "  [{$index}] {$url}\n";
        }
    }
} else {
    echo "No posts found\n";
}
