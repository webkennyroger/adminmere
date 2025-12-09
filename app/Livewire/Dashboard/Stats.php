<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Stats extends Component
{
    public $totalUsers;
    public $freeUsers;
    public $premiumUsers;
    public $revenueGoal;
    public $activeGoals = [];

    public function mount()
    {
        $this->totalUsers = \App\Models\User::count();
        $this->freeUsers = \App\Models\User::where('plan', 'free')->count();
        $this->premiumUsers = \App\Models\User::where('plan', '!=', 'free')->count();
        
        // Fetch goals for the current month and key by metric
        $this->activeGoals = \App\Models\Goal::where('period', 'monthly')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get()
            ->keyBy('metric');
            
        $this->revenueGoal = $this->activeGoals['revenue']->target_value ?? 0;
    }

    public function render()
    {
        return view('livewire.dashboard.stats');
    }
}
