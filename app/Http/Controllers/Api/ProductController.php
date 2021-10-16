<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductStore;
use App\Http\Requests\ProductUpdate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStore $request)
    {
        $data = $request->all();
        if($request->hasFile('img')) { 
            $getImage = $request->file('img');
            $imagePath = storage_path(). '/app/images/';
            $imgname = time().$data['img']->getClientOriginalName();
            $data['img'] = '/app/images/'.$imgname;
            $getImage->move($imagePath, $imgname);
        }
        else{
            return ['result'=>'del có file'];
        }
        Product::create($data);
       
        return response()->json([
            'message'=>  'Thêm thành công',
            'data'=>$data
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdate $request, Product $product)
    {
        $product->update($request->all());
        return response()->json([
            'message'=>  'Sửa thành công',
            'data'=>$product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message'=>  'xóa thành công',
            'data'=>$product
        ]);
    }
}
