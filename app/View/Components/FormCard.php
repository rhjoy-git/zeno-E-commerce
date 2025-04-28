<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormCard extends Component
{
    public string $title;
    public ?string $subtitle;

    public function __construct(string $title, ?string $subtitle = null)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    public function render(): View|Closure|string
    {
        return view('components.auth.form-card');
    }
}