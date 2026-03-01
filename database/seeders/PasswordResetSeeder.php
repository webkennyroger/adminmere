<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PasswordResetSeeder extends Seeder
{
    public function run()
    {
        $email = 'webkennyroger@gmail.com';
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make('12345678');
            $user->save();
            $this->command->info("Password for $email reset to: 12345678");
        } else {
            $this->command->error("User $email not found!");
        }
    }
}
