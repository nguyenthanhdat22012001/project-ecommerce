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
        try {
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
            'success' => true,
            'message'=>  'Thêm thành công',
            'data'=>$data
        ]);
    }catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message'=>'Them that bai'
        ]);
    }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        try {
            return response()->json([
                'title'=>'Show Category',
                'message'=>'Lay du lieu thanh cong',
                'data'=>$product
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'Show Category',
                'message'=>'Lay du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    
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
        try {
                $product->update($request->all());
                 return response()->json([
                'title'=>'update product',
                'message'=>  'update thành công',
                'data'=>$product
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'update product',
                'message'=>'update du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
                $product->delete();
                return response()->json([
                    'title'=>'delete product',
                    'message'=>  'xóa thành công',
                    'data'=>$product
            ]);
    }catch (\Exception $e){
        return response()->json([
            'title'=>'delete product',
            'message'=>'xoa du lieu that bai',
            'errors'=>$e->getMessage()
        ]);
    }
      
    }
}
