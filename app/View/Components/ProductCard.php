<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCard extends Component
{
    // ProductCard.php
    public $id, $image, $title, $price, $badge, $stock, $categories;

    public function __construct($id, $image, $title, $price, $badge = null, $stock = true, $categories = '')
    {
        $this->id = $id;
        $this->image = $image;
        $this->title = $title;
        $this->price = $price;
        $this->badge = $badge;
        $this->stock = $stock;
        $this->categories = $categories;
    }

    public function render(): View|Closure|string
    {
        return view('components.product-card');
    }
}
