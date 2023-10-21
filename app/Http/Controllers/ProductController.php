<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $products = Product::all();
        return Inertia::render('Frontend/Products', compact('products'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Backend/Products/Index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Backend/Products/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required',
        ]);
        Product::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        sleep(1);

        return redirect('/admin/products')->with('message', 'Product Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render(
            'Backend/Products/Edit',
            [
                'product' => $product,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required',
        ]);

        $product->title = $request->title;
        $product->subtitle = $request->subtitle;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        sleep(1);

        return redirect('/admin/products')->with('message', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        sleep(1);

        return redirect('/admin/products')->with('message', 'Product Deleted Successfully');
    }
}
