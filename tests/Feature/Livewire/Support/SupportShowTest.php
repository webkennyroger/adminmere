<?php

namespace Tests\Feature\Livewire\Support;

use App\Models\Support;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_support_detail()
    {
        $user = User::factory()->create();
        $ticket = Support::create([
            'user_id' => $user->id,
            'subject' => 'Test Ticket',
            'message' => 'Message content',
            'status' => 'pending',
            'priority' => 'low',
        ]);

        $this->actingAs($user)
            ->get(route('support.show', $ticket))
            ->assertOk()
            ->assertSee($ticket->subject);
    }

    public function test_cannot_view_others_ticket()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $ticket = Support::create([
            'user_id' => $otherUser->id,
            'subject' => 'Other Ticket',
            'message' => 'Message content',
            'status' => 'pending',
            'priority' => 'low',
        ]);

        $this->actingAs($user)
            ->get(route('support.show', $ticket))
            ->assertForbidden();
    }

    public function test_404_for_non_existent_ticket()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('support.show', 99999))
            ->assertNotFound();
    }
}
