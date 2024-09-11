<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        Product::create($validatedData);

        return response()->json(['success' => 'Product added successfully']);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $product->update($validatedData);

        return response()->json(['success' => 'Product updated successfully']);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully']);
    }

    public function getProducts()
    {
        $products = Product::select(['id', 'name', 'description', 'price', 'quantity']);

        return Datatables::of($products)
            ->addColumn('action', function ($product) {
                $editBtn = '<button class="btn btn-primary btn-sm edit-product" data-id="' . $product->id . '">Edit</button>';
                $deleteBtn = '<button class="btn btn-danger btn-sm delete-product" data-id="' . $product->id . '">Delete</button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getProduct(Product $product)
    {
        return response()->json($product);
    }
}