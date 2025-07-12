<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $products = [
        [
            'image' => 'images/1.jpg',
            'title' => "Men's Casual Shirt",
            'price' => 49.99,
            'badge' => 'New',
            'stock' => true,
            'categories' => 'men women',
        ],
        [
            'image' => 'images/2.jpg',
            'title' => 'Vintage Hoodie',
            'price' => 89.99,
            'badge' => 'Sale',
            'stock' => false,
            'categories' => 'men',
        ],
        [
            'image' => 'images/3.jpg',
            'title' => 'Ladies T-Shirt',
            'price' => 29.99,
            'badge' => 'Hot',
            'stock' => true,
            'categories' => 'women',
        ],
        [
            'image' => 'images/4.jpg',
            'title' => 'Running Shoes',
            'price' => 119.99,
            'badge' => 'New',
            'stock' => false,
            'categories' => 'men women',
        ],
        [
            'image' => 'images/5.jpg',
            'title' => 'Winter Jacket',
            'price' => 149.99,
            'badge' => 'Limited',
            'stock' => true,
            'categories' => 'kids women',
        ],
        [
            'image' => 'images/6.jpg',
            'title' => 'Winter Jacket',
            'price' => 149.99,
            'badge' => 'Limited',
            'stock' => false,
            'categories' => 'men women',
        ],
        [
            'image' => 'images/7.jpg',
            'title' => 'Winter Jacket',
            'price' => 149.99,
            'badge' => 'Limited',
            'stock' => true,
            'categories' => 'kids women',
        ],
        [
            'image' => 'images/8.jpg',
            'title' => 'Winter Jacket',
            'price' => 149.99,
            'badge' => 'Limited',
            'stock' => false,
            'categories' => 'men women',
        ],
    ];
    public function index()
    {
        return view('frontend.product-list', ['products' => $this->products]);
    }
    public function show(string $id)
    {
        return view('frontend.product-details', ['products' => $this->products]);
    }
}
