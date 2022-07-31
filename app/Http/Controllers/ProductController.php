<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

use function PHPUnit\Framework\returnSelf;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return response()->json([
            "success" => true,
            "message" => "Product List",
            "data" => $product
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
            }
            $product = Product::create($input);
            return response()->json([
            "success" => true,
            "message" => "Product created successfully.",
            "data" => $product
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json([
                "success" => true,
                "message" => "Product cannot be found.",
                "data" => $product
                ]);
        } else {
            return response()->json([
                "success" => true,
                "message" => "Product retrieved successfully.",
                "data" => $product
                ]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $product = Product::where('id', $id)->get()->first();
        if (empty($product)) {
            return response()->json([
                'message' => 'Product cannot be found',
                'data' => $product
            ], 404);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'category_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product cannot be updated',
                    'data' =>$validator->errors()->all()
                ], 404);
            }
            $product->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product
            ]);
        }

    //     $this->validate($request, [
    //             'name' => 'required',
    //             'price' => 'required',
    //             'quantity' => 'required',
    //             'category_id' => 'required',
    //     ]);
    //     $product = Product::find($id);
    //     $product->name = $request['name'];
    //     $product->price = $request['price'];
    //     $product->quantity = $request['price'];
    //     $product->category_id = $request['category_id'];
    //     $product->save();

    // return response()->json([
    //         "success" => true,
    //         "message" => "Product updated successfully.",
    //         "data" => $product
    //     ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        
        if ($product->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Product deleted'
            ]);
        }
    }
}
