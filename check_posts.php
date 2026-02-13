<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$posts = \App\Models\Post::latest()->take(5)->get();
foreach ($posts as $p) {
    echo "ID: {$p->id} | Content: {$p->content} | Privacy: {$p->privacy} | Media: " . json_encode($p->media) . " | Created: {$p->created_at}\n";
}
