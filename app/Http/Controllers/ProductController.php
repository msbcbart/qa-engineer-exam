<?php

namespace App\Http\Controllers;

use App\Enums\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('product.index')->with([
            'token' => $request->cookie('access_token'),
            'categories' => json_encode(ProductCategory::getOptions())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function form(Request $request, Product $product = null)
    {
        if ($product) {
            $product->load(['media']);
        }

        return view('product.form', compact('product'))->with([
            'token' => $request->cookie('access_token'),
            'categories' => json_encode(ProductCategory::getOptions())
        ]);
    }
}
