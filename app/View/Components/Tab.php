<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Tab extends Component
{
    /**
     * Cria uma nova instância do componente.
     */
    public function __construct()
    {
        // Este componente não precisa de propriedades, pois usa slots nomeados.
    }

    /**
     * Obtém a view/conteúdo que representa o componente.
     */
    public function render(): View
    {
        return view('components.tab');
    }
}