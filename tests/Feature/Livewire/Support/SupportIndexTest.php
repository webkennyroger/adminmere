<?php

namespace Tests\Feature\Livewire\Support;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupportIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_support_create_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('support.index'))
            ->assertOk()
            ->assertSee('Abrir Novo Ticket');
    }

    public function test_can_create_ticket()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\Support\SupportIndex::class)
            ->set('subject', 'New Ticket')
            ->set('priority', 'high')
            ->set('message', 'Help me with this issue.')
            ->call('submitSupportForm')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('supports', [
            'subject' => 'New Ticket',
            'priority' => 'high',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);
    }

    public function test_validation_works()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\Support\SupportIndex::class)
            ->set('subject', '')
            ->call('submitSupportForm')
            ->assertHasErrors(['subject']);
    }
}
