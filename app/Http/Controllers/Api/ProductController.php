<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with('category')->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 'berhasil mengambil data produk',
            'data' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|unique:products',
            'description' => 'nullable',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'criteria' => 'required',
        ]);

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $request->image;
        $product->criteria = $request->criteria;
        $product->stock = $request->stock;
        $product->status = 'published';
        $product->save();

        if ($request->file('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.png');
            $product->image = 'products/' . $product->id . '.png';
            $product->save();
        }

        $product = Product::with('category')->find($product->id);
        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::FindOrFail($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'produk tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $product = Product::findOrFail($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'produk tidak ditemukan'
            ], 404);
        }

        //$product->category_id = $request->category_id;
        $product->name = $request->name;
       // $product->description = $request->description;
        $product->price = $request->price;
         // $product->image = $request->image;
         $product->stock = $request->stock;
        $product->criteria = $request->criteria;
        $product->save();

        //if ($request->file('image')) {
            //$image = $request->file('image');
           // $image->storeAs('public/products', $product->id . '.png');
           // $product->image = 'products/' . $product->id . '.png';
           // $product->save();
       // }

        $product = Product::with('category')->find($product->id);
        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'produk tidak ditemukan'
            ], 404);
        }
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'produk berhasil dihapus'
        ], 200);
    }
}
