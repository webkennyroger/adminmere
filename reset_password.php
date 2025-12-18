<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = \App\Models\User::where('email', 'webkennyroger@gmail.com')->first();
if($u) {
    $u->password = bcrypt('password');
    $u->save();
    echo "Password Reset Done for " . $u->email . "\n";
} else {
    echo "User not found.\n";
}
