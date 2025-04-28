<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $type = 'submit'
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.auth.button');
    }
}