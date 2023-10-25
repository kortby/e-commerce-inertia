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
        // dd(auth()->user()->id);
        $products = Product::where('user_id', auth()->user()->id)->get();
        return Inertia::render('Backend/Products/Index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        return Inertia::render(
            'Backend/Products/Create',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data, including the uploaded images.
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each uploaded image.
            'user_id' => 'required', // Validate each uploaded image.
        ]);

        // dd($request->all());
        if (auth()->check()) {
            // Create a new product.
            $product = Product::create([
                'title' => $request->input('title'),
                'subtitle' => $request->input('subtitle'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'user_id' => $request->input('user_id'),
            ]);

            // Handle and attach the uploaded images to the product using Spatie Media Library.
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $product->addMedia($image)->toMediaCollection('product_collection');
                }
            }

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        }
        return redirect()->route('login')->with('error', 'You must be logged in to create a product.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $image_product =  $product->getMedia('product_collection')->first() ?  $product->getMedia('product_collection')->first()->getUrl() : 'https://picsum.photos/200/300';
        return Inertia::render(
            'Backend/Products/Show',
            [
                'product' => $product,
                'image_product' => $image_product,
            ]
        );
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
