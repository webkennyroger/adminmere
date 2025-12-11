<?php

namespace App\Livewire\Dashboard;

use App\Models\User; // Assuming User model exists
use Livewire\Component;
use Illuminate\Support\Carbon;

class UserGrowthChart extends Component
{
    public $totalUsers;
    public $usersThisMonth;
    public $usersLastMonth;
    public $monthlyGrowth;
    
    public $yearlyCount;
    public $quarterlyCount;

    public function mount()
    {
        // Example logic - adjust based on actual requirements
        $this->totalUsers = User::count();
        
        $now = Carbon::now();
        
        // Monthly stats
        $this->usersThisMonth = User::whereMonth('created_at', $now->month)
                                    ->whereYear('created_at', $now->year)
                                    ->count();
                                    
        $this->usersLastMonth = User::whereMonth('created_at', $now->subMonth()->month)
                                    ->whereYear('created_at', $now->subMonth()->year)
                                    ->count();

        // Avoid division by zero
        if ($this->usersLastMonth > 0) {
            $this->monthlyGrowth = (($this->usersThisMonth - $this->usersLastMonth) / $this->usersLastMonth) * 100;
        } else {
            $this->monthlyGrowth = 100; // Simulating 100% growth if started from 0
        }

        // Yearly Count (Current Year)
        $this->yearlyCount = User::whereYear('created_at', Carbon::now()->year)->count();

        // Quarterly Count (Current Quarter)
        $startOfQuarter = Carbon::now()->startOfQuarter();
        $endOfQuarter = Carbon::now()->endOfQuarter();
        $this->quarterlyCount = User::whereBetween('created_at', [$startOfQuarter, $endOfQuarter])->count();
    }

    public function render()
    {
        return view('livewire.dashboard.charts.user-growth-chart');
    }
}
