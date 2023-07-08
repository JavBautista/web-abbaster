<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function getProductsFeatured(){
        $products_featured = Product::where('destacado_gral', 1)
                            ->orderBy('destacado_gral_order','asc')
                            ->paginate(10);

        return $products_featured;
    }
}
