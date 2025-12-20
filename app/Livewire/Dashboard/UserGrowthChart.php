<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Carbon;

// Configurar Carbon para português
Carbon::setLocale('pt_BR');

class UserGrowthChart extends Component
{
    public $period = 'monthly'; // 'monthly', 'quarterly', 'yearly'
    
    // Users data
    public $totalUsers;
    public $currentPeriodUsers;
    public $usersGrowthPercentage;
    
    // Subscribers data (mock for now)
    public $totalSubscribers;
    public $currentPeriodSubscribers;
    public $subscribersGrowthPercentage;
    
    // Chart data arrays
    public $chartLabels = [];
    public $usersChartValues = [];
    public $subscribersChartValues = [];

    public function mount()
    {
        $this->loadChartData();
    }

    public function updatedPeriod()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $this->loadUsersData();
        $this->loadSubscribersData();
    }

    private function loadUsersData()
    {
        $this->totalUsers = User::count();
        
        $now = Carbon::now();
        
        if ($this->period === 'monthly') {
            // Current month
            $this->currentPeriodUsers = User::whereMonth('created_at', $now->month)
                                            ->whereYear('created_at', $now->year)
                                            ->count();
            
            // Previous month
            $previousPeriodUsers = User::whereMonth('created_at', $now->copy()->subMonth()->month)
                                       ->whereYear('created_at', $now->copy()->subMonth()->year)
                                       ->count();
            
            // Chart data - last 12 days
            $chartData = $this->getUsersMonthlyChartData();
            
        } elseif ($this->period === 'quarterly') {
            // Current quarter
            $startOfQuarter = $now->copy()->startOfQuarter();
            $endOfQuarter = $now->copy()->endOfQuarter();
            
            $this->currentPeriodUsers = User::whereBetween('created_at', [$startOfQuarter, $endOfQuarter])->count();
            
            // Previous quarter
            $previousQuarterStart = $startOfQuarter->copy()->subQuarter()->startOfQuarter();
            $previousQuarterEnd = $startOfQuarter->copy()->subQuarter()->endOfQuarter();
            $previousPeriodUsers = User::whereBetween('created_at', [$previousQuarterStart, $previousQuarterEnd])->count();
            
            // Chart data - last 12 weeks
            $chartData = $this->getUsersQuarterlyChartData();
            
        } else { // yearly
            // Current year
            $this->currentPeriodUsers = User::whereYear('created_at', $now->year)->count();
            
            // Previous year
            $previousPeriodUsers = User::whereYear('created_at', $now->year - 1)->count();
            
            // Chart data - last 12 months
            $chartData = $this->getUsersYearlyChartData();
        }
        
        // Calculate growth percentage
        if ($previousPeriodUsers > 0) {
            $this->usersGrowthPercentage = (($this->currentPeriodUsers - $previousPeriodUsers) / $previousPeriodUsers) * 100;
        } else {
            $this->usersGrowthPercentage = $this->currentPeriodUsers > 0 ? 100 : 0;
        }
        
        $this->chartLabels = $chartData['labels'];
        $this->usersChartValues = $chartData['data'];
    }

    private function loadSubscribersData()
    {
        // Mock data for subscribers (50% of users)
        $this->totalSubscribers = (int)($this->totalUsers * 0.5);
        $this->currentPeriodSubscribers = (int)($this->currentPeriodUsers * 0.5);
        
        // Mock growth (slightly different from users)
        $this->subscribersGrowthPercentage = $this->usersGrowthPercentage * 0.8;
        
        // Mock chart data (70% of users data)
        $this->subscribersChartValues = array_map(function($value) {
            return (int)($value * 0.7);
        }, $this->usersChartValues);
    }

    private function getUsersMonthlyChartData()
    {
        $data = [];
        $labels = [];
        
        // Get last 12 days
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = User::whereDate('created_at', $date)->count();
            
            $data[] = $count;
            $labels[] = $date->translatedFormat('d M');
        }
        
        return ['labels' => $labels, 'data' => $data];
    }

    private function getUsersQuarterlyChartData()
    {
        $data = [];
        $labels = [];
        
        // Get last 12 weeks
        for ($i = 11; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            $count = User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            
            $data[] = $count;
            $labels[] = $startOfWeek->translatedFormat('d M');
        }
        
        return ['labels' => $labels, 'data' => $data];
    }

    private function getUsersYearlyChartData()
    {
        $data = [];
        $labels = [];
        
        // Get last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = User::whereMonth('created_at', $date->month)
                         ->whereYear('created_at', $date->year)
                         ->count();
            
            $data[] = $count;
            $labels[] = ucfirst($date->translatedFormat('M'));
        }
        
        return ['labels' => $labels, 'data' => $data];
    }

    public function render()
    {
        return view('livewire.dashboard.charts.user-growth-chart');
    }
}
