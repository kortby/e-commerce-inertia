<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
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
        foreach ($products as $product) {
            $product['media'] = $product->getMedia('product_collection')->first() ?  $product->getMedia('product_collection')->first()->getUrl() : 'https://picsum.photos/200/300';
        }
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
    public function store(ProductRequest $request)
    {
        // dd(auth()->user()->can('create-product'));
        // dd(auth()->user()->hasRole('Super-Admin'));
        // Create a new product.
        $product = Product::create($request->all());
        // dd($product);

        // Handle and attach the uploaded images to the product using Spatie Media Library.
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection('product_collection');
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
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
        $product->loadMedia('product_collection');

        return Inertia::render(
            'Backend/Products/Edit',
            [
                'product' => $product,
                'user' => auth()->user(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        // dd($request->all);
        // Update product details.
        $product->update([
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'user_id' => $request->input('user_id'),
        ]);

        // Handle and attach the uploaded images to the product using Spatie Media Library.
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection('product_images');
            }
        }

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
