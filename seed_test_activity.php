<?php
// Script para criar atividade de TESTE com GPS real no banco
// Rodar com: php seed_test_activity.php
// Deletar depois de testar!

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Coordenadas GPS simulando uma corrida em Cuiabá, MT (Centro → Praça Alencastro)
$routePoints = [
    ['lat' => -15.5989, 'lng' => -56.0949],
    ['lat' => -15.5992, 'lng' => -56.0942],
    ['lat' => -15.5995, 'lng' => -56.0935],
    ['lat' => -15.5999, 'lng' => -56.0927],
    ['lat' => -15.6003, 'lng' => -56.0919],
    ['lat' => -15.6007, 'lng' => -56.0911],
    ['lat' => -15.6012, 'lng' => -56.0903],
    ['lat' => -15.6016, 'lng' => -56.0895],
    ['lat' => -15.6021, 'lng' => -56.0887],
    ['lat' => -15.6025, 'lng' => -56.0879],
    ['lat' => -15.6029, 'lng' => -56.0871],
    ['lat' => -15.6033, 'lng' => -56.0863],
    ['lat' => -15.6037, 'lng' => -56.0855],
    ['lat' => -15.6041, 'lng' => -56.0847],
    ['lat' => -15.6045, 'lng' => -56.0839],
    ['lat' => -15.6049, 'lng' => -56.0831],
    ['lat' => -15.6053, 'lng' => -56.0823],
    ['lat' => -15.6057, 'lng' => -56.0815],
    ['lat' => -15.6061, 'lng' => -56.0807],
    ['lat' => -15.6065, 'lng' => -56.0799],
];

// Pegar o primeiro usuário do banco
$user = App\Models\User::first();
if (!$user) {
    echo "❌ Nenhum usuário encontrado no banco!\n";
    exit(1);
}

echo "✅ Usuário: {$user->name} (ID: {$user->id})\n";

// Criar a atividade de teste
$activity = App\Models\Activity::create([
    'user_id'    => $user->id,
    'title'      => 'Corrida Teste - Mapa GPS ✅',
    'sport_type' => 'running',
    'start_time' => now()->subHours(2),
    'distance'   => 5200, // 5.2 km em metros
    'duration'   => 1800, // 30 minutos em segundos
    'calories'   => 420,
    'location'   => 'Cuiabá, MT',
    'privacy'    => 'public',
    'feed_type'  => 'feed',
    'polylines'  => [
        'points'           => $routePoints,
        'summary_polyline' => '',
    ],
]);

echo "✅ Atividade criada: ID={$activity->id}\n";
echo "✅ Polylines salvas: " . json_encode($activity->polylines) . "\n";
echo "\n🎯 AGORA ACESSE: https://kennyroger.com.br/home\n";
echo "     O mapa deve aparecer na atividade 'Corrida Teste - Mapa GPS'\n";
echo "\n⚠️  Lembre de deletar esta atividade de teste depois!\n";
echo "   Delete com: App\\Models\\Activity::find({$activity->id})->delete();\n";
