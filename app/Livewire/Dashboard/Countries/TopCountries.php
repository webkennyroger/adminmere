<?php

namespace App\Livewire\Dashboard\Countries;

use Livewire\Component;

class TopCountries extends Component
{
    public $countries = [];

    public function mount()
    {
        $this->countries = [
            ['name' => 'Estados Unidos', 'flag' => 'usa.svg', 'users' => 12450, 'trend' => 'up'],
            ['name' => 'China', 'flag' => 'china.svg', 'users' => 7230, 'trend' => 'up'],
            ['name' => 'Austrália', 'flag' => 'australia.svg', 'users' => 6410, 'trend' => 'up'],
            ['name' => 'Índia', 'flag' => 'india.svg', 'users' => 5975, 'trend' => 'down'],
            ['name' => 'Brasil', 'flag' => 'brazil.svg', 'users' => 2330, 'trend' => 'up'],
            ['name' => 'Reino Unido', 'flag' => 'united-kingdom.svg', 'users' => 1620, 'trend' => 'up'],
            ['name' => 'Singapura', 'flag' => 'singapura.svg', 'users' => 1855, 'trend' => 'up'],
            ['name' => 'Bélgica', 'flag' => 'belgica.svg', 'users' => 874, 'trend' => 'down'],
            ['name' => 'Finlândia', 'flag' => 'finlandia.svg', 'users' => 898, 'trend' => 'up'],
            ['name' => 'Iêmen', 'flag' => 'Iemen.svg', 'users' => 758, 'trend' => 'down'],
            ['name' => 'Bangladesh', 'flag' => 'bangladesh.svg', 'users' => 703, 'trend' => 'up'],
            ['name' => 'França', 'flag' => 'france.svg', 'users' => 680, 'trend' => 'up'],
            ['name' => 'Japão', 'flag' => 'japan.svg', 'users' => 624, 'trend' => 'up'],
            ['name' => 'Rússia', 'flag' => 'russia.svg', 'users' => 579, 'trend' => 'down'],
            ['name' => 'Espanha', 'flag' => 'spain.svg', 'users' => 501, 'trend' => 'up'],
            ['name' => 'Itália', 'flag' => 'italy.svg', 'users' => 466, 'trend' => 'up'],
        ];

        // Sort by users descending
        usort($this->countries, function ($a, $b) {
            return $b['users'] <=> $a['users'];
        });
    }

    public function render()
    {
        return view('livewire.dashboard.countries.top-countries');
    }
}
