<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$activities = App\Models\Activity::latest()->take(5)->get();
foreach ($activities as $a) {
    $poly = $a->polylines;
    $polyStr = $poly ? substr(json_encode($poly), 0, 120) : 'NULL/EMPTY';
    echo "ID:{$a->id} | dist:{$a->distance} | polylines: {$polyStr}" . PHP_EOL;
}
