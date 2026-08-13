<?php

namespace App\Http\Controllers;

use App\Models\Product;

class StoreProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::with('images')
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return view('store.products.show', compact('product'));
    }
}
