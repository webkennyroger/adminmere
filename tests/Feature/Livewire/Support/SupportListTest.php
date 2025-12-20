<?php

namespace Tests\Feature\Livewire\Support;

use App\Models\User;
use App\Models\Support;
use Livewire\Livewire;
use Tests\TestCase;

class SupportListTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    public function test_can_view_support_list()
    {
        $user = User::factory()->create();
        Support::create([
            'user_id' => $user->id,
            'subject' => 'Test Ticket 1',
            'message' => 'Message 1',
            'status' => 'open',
            'priority' => 'low',
        ]);

        $this->actingAs($user)
            ->get(route('support.list'))
            ->assertOk()
            ->assertSee('Test Ticket 1')
            ->assertSee('Lista de Tickets');
    }

    public function test_can_filter_by_status()
    {
        $user = User::factory()->create();
        Support::create([
            'user_id' => $user->id,
            'subject' => 'Pending Ticket',
            'status' => 'pending',
            'message' => 'msg', 'priority' => 'low'
        ]);
        Support::create([
            'user_id' => $user->id,
            'subject' => 'Solved Ticket',
            'status' => 'solved',
            'message' => 'msg', 'priority' => 'low'
        ]);

        Livewire::actingAs($user)
            ->test(\App\Livewire\Support\SupportList::class)
            ->set('status', 'solved')
            ->assertSee('Solved Ticket')
            ->assertDontSee('Pending Ticket');
    }

    public function test_can_search_tickets()
    {
        $user = User::factory()->create();
        Support::create([
            'user_id' => $user->id,
            'subject' => 'Find Me',
            'message' => 'msg', 'priority' => 'low', 'status' => 'open'
        ]);
        Support::create([
            'user_id' => $user->id,
            'subject' => 'Hide Me',
            'message' => 'msg', 'priority' => 'low', 'status' => 'open'
        ]);

        Livewire::actingAs($user)
            ->test(\App\Livewire\Support\SupportList::class)
            ->set('search', 'Find')
            ->assertSee('Find Me')
            ->assertDontSee('Hide Me');
    }

    public function test_can_sort_tickets()
    {
        $user = User::factory()->create();
        $ticket1 = Support::create(['user_id' => $user->id, 'subject' => 'A Ticket', 'created_at' => now()->subDay(), 'message' => 'm', 'status' => 'o', 'priority' => 'l']);
        $ticket2 = Support::create(['user_id' => $user->id, 'subject' => 'B Ticket', 'created_at' => now(), 'message' => 'm', 'status' => 'o', 'priority' => 'l']);

        Livewire::actingAs($user)
            ->test(\App\Livewire\Support\SupportList::class)
            ->set('sortBy', 'subject')
            ->set('sortAsc', true)
            ->assertSeeInOrder(['A Ticket', 'B Ticket'])
            ->set('sortAsc', false)
            ->assertSeeInOrder(['B Ticket', 'A Ticket']);
    }
}
