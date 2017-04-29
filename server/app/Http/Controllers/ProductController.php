<?php

namespace App\Http\Controllers;

use Carbon;
use App\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response($products);
    }

    public function store(Request $request)
    {
        try {
            $input = $request->all();

            $product = new Product();
            $product->name = $input['name'];
            $product->price = $input['price'];
            $product->inventory = $input['inventory'];
            $product->save();

            $result = array(
                'result' => true,
                'message' => 'Product Saved!',
                'product' => $product
            );
        } catch(\Exception $e) {
            $result = array(
                'result' => false,
                'message' => $e->getMessage()
            );
        }

        return response($result);
    }

    public function update(Request $request)
    {
        try {
            $input = $request->all();
            
            $product = Product::find( $input['id'] );
            $product->name = $input['name'];
            $product->price = $input['price'];
            $product->inventory = $input['inventory'];
            $product->save();

            $result = array(
                'result' => true,
                'message' => 'Product Updated!',
                'product' => $product
            );
        } catch(\Exception $e) {
            $result = array(
                'result' => false,
                'message' => $e->getMessage()
            );
        }

        return response($result);
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        
        $product = Product::find($input['id']);
        $product->delete();
        $result = array(
                'result' => true,
                'message' => 'Product Deleted!'
            );
        return response($result);
    }
}
