<?php

namespace Database\Seeders;

use App\Models\Support;
use App\Models\User;
use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating 10 Support Tickets...');

        // Ensure we have users
        if (User::count() === 0) {
            User::factory(1)->create();
        }

        // Create exactly 10 tickets distributed among random users
        // Create manual tickets instead of factory
        $user = User::first();
        if ($user) {
            Support::create([
                'user_id' => $user->id,
                'subject' => 'Problema com login',
                'message' => 'Não consigo acessar minha conta premium.',
                'status' => 'open',
                'priority' => 'high'
            ]);

            Support::create([
                'user_id' => $user->id,
                'subject' => 'Dúvida sobre planos',
                'message' => 'Quais as formas de pagamento aceitas?',
                'status' => 'pending',
                'priority' => 'medium'
            ]);
        }

        // Factory disabled
        // Support::factory(10)->create([...]);
    }
}
