<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public string $name,
        public string $type = 'text',
        public ?string $label = null,
        public ?string $placeholder = null,
        public string $value = '',
        public bool $required = false,
        public ?string $id = null,
        public string $class = '',
        public bool $autocomplete = false,
        public bool $disabled = false,
        public bool $readonly = false,
        public bool $autofocus = false
    ) {
        $this->id = $id ?? $name;
    }

    public function render(): View|Closure|string
    {
        return view('components.auth.input');
    }
}