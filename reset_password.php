<?php
$u = \App\Models\User::where('email', 'webkennyroger@gmail.com')->first();
if($u) {
    $u->password = bcrypt('password');
    $u->save();
    echo "Password Reset Done for " . $u->email . "\n";
} else {
    echo "User not found.\n";
}
