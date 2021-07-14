<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    public function index()
    {
        $products= Product::all();
        return response()->json([
            "success" => true,
            "message" => "Product List",
            "data" => $products
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'detail' => 'required'
        ],
        [
            'required' =>'Vui lòng nhập đầy đủ các trường'
        ]);
        if($validator->fails()) {
            return response()->json([
                'Error' => $validator->errors()
            ]);       
        }
        $product = Product::create($request->all());
        return response()->json([
            "success" => true,
            "message" => "Product created successfully.",
            "data" => $product
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            // return $this->sendError('Product not found.');
            return response()->json([
                "Error" => "Product not found."
            ],404);
        }
        return response()->json([
            "success" => true,
            "message" => "Product retrieved successfully.",
            "data" => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'detail' => 'required'
        ]);
        if($validator->fails()){
            // return $this->sendError('Validation Error.', $validator->errors());  
            return response()->json([
                'Error' => $validator->errors()
            ]);         
        }
        $product=Product::find($id);
        if (is_null($product)) {
            // return $this->sendError('Product not found.');
            return response()->json([
                "Error" => "Product not found."
            ],404);
        }
        $product->name = $request['name'];
        $product->detail = $request['detail'];
        $product->save();
        return response()->json([
            "success" => true,
            "message" => "Product updated successfully.",
            "data" => $product
            ]);
    }

    public function destroy($id)
    {
        $product=Product::find($id);
        if (is_null($product)) {
            // return $this->sendError('Product not found.');
            return response()->json([
                "Error" => "Product not found."
            ],404);
        }
        $product->delete();
        return response()->json([
            "success" => true,
            "message" => "Product deleted successfully.",
            "data" => $product
        ]);
    }
}
