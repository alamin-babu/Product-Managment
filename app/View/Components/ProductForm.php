<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductForm extends Component
{
    public $product;

    public function __construct($product = null)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('components.product-form');
    }
}