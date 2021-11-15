<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CmtRating;

class MainProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_product_by(Request $request)
    {
        try {
            $query = Product::query();
        //     $s = $request->input('search');
        //    $query->whereRaw("name LIKE '%". $s ."%'" )->orWhereRaw("description LIKE '%". $s ."%'" );
        if($request->key == 'cate'){
            $data = $query->whereRaw("cate_id = ". $request->value );
        }
        if($request->key == 'brand'){
            $data = $query->whereRaw("brand_id = ". $request->value );
        }
        if($request->key == 'store'){
            $data = $query->whereRaw("store_id = ". $request->value );
        }
        if($request->key == 'sort'){
            $data = $query->orderBy( $request->value, $request->by);
        }
            return response()->json([
                'success' => true,
                'message'=>  'lấy dữ liệu thành công',
                'data'=>$data->get()
        ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>'lay du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    public function get_comment_by_product($product_id)
    {
        //
        try {
            $query = CmtRating::query();
            $query->whereRaw("product_id = ". $product_id );
       return response()->json([
        'success' => true,
        'message'=>  'Tìm thành công',
        'data'=>$query->get()
    ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>'tim du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

   
}
