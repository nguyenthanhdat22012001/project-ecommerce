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
        try {
            $data = Product::all();
            return response()->json([
                'success' => true,
                'message'=>  'lấy dữ liệu thành công',
                'data'=>$data
            ]);
            }catch (\Exception $e){
                return response()->json([
                    'success' => false,
                    'message'=>'Lay du lieu that bai',
                    'errors'=>$e->getMessage()
                ]);
            }
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
            return ['result'=>'không có file'];
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
    public function show($product)
    {
        try {
            $data = Product::find($product);
            if($data != null){
                return response()->json([
                    'success' => true,
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$data
                ]);
            }
            else{
                return response()->json([
                    'success' => true,
                    'message'=>'Dữ liệu không tồn tại',
                    'data'=>$data
                ]);
            }
            
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
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
    public function update(ProductUpdate $request, $product)
    {
        try {
                $data = Product::find($product);
                if($data != null){
                    $data->update($request->all());
                    return response()->json([
                        'success' => true,
                        'message'=>  'update thành công',
                        'data'=>$data
                    ]);
                }
                else{
                    return response()->json([
                        'success' => true,
                        'message'=>  'Dữ liệu không tồn tại',
                        'data'=>$data
                    ]);
                }
                
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
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
                $data = Product::find($product);
                if($data != null){
                    $data->delete();
                    return response()->json([
                        'success' => true,
                        'message'=>  'xóa thành công',
                        'data'=>$data
                    ]);
                }
                else{
                    return response()->json([
                        'success' => true,
                        'message'=>  'Dữ liệu không tồn tại',
                        'data'=>$data
                    ]);
                }
                
    }catch (\Exception $e){
        return response()->json([
            'success' => false,
            'message'=>'xoa du lieu that bai',
            'errors'=>$e->getMessage()
        ]);
    }
      
    }
}
