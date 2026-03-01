<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class SocialMediaStats extends Component
{
    public $stats = [];

    public $overallGrowth = 3.3;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Aqui você integraria com uma API real ou banco de dados.
        // Simulando dados para demonstração:
        $this->stats = [
            [
                'name' => 'Instagram',
                'handle' => '@mere.app',
                'growth' => 2,
                'path' => 'M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8 1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5 5 5 0 0 1-5 5 5 5 0 0 1-5-5 5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3z',
                'color_bg' => 'bg-pink-100 dark:bg-pink-500/20',
                'color_text' => 'text-pink-600 dark:text-pink-400',
            ],
            [
                'name' => 'Facebook',
                'handle' => '@mere',
                'growth' => 3,
                'path' => 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z',
                'color_bg' => 'bg-blue-100 dark:bg-blue-500/20',
                'color_text' => 'text-blue-600 dark:text-blue-400',
            ],
            [
                'name' => 'Tik Tok',
                'handle' => '@mere',
                'growth' => 1,
                'path' => 'M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z',
                'color_bg' => 'bg-zinc-100 dark:bg-zinc-700/50',
                'color_text' => 'text-zinc-900 dark:text-zinc-100',
            ],
            [
                'name' => 'Twitter',
                'handle' => '@mere',
                'growth' => 5,
                'path' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z', // X logo
                'color_bg' => 'bg-sky-100 dark:bg-sky-500/20',
                'color_text' => 'text-sky-600 dark:text-sky-400',
            ],
            [
                'name' => 'Discord',
                'handle' => '@mere',
                'growth' => 3,
                'path' => 'M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994.021-.041-.001-.09-.041-.106a13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z',
                'color_bg' => 'bg-indigo-100 dark:bg-indigo-500/20',
                'color_text' => 'text-indigo-600 dark:text-indigo-400',
            ],
            [
                'name' => 'Youtube',
                'handle' => '@mere',
                'growth' => 2,
                'path' => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z',
                'color_bg' => 'bg-red-100 dark:bg-red-500/20',
                'color_text' => 'text-red-600 dark:text-red-400',
            ],
        ];
    }

    public function refreshData()
    {
        // Simula atualização de dados
        // Em produção, isso chamaria as APIs novamente
        $this->overallGrowth = 3.3 + (rand(-5, 5) / 10);

        foreach ($this->stats as &$stat) {
            $stat['growth'] = max(0, $stat['growth'] + rand(-1, 1));
        }
    }

    public function render()
    {
        return view('livewire.dashboard.socialmedia.social-media-stats');
    }
}
