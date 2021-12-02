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
            $data = CmtRating::with('user:id,name')
                ->where('product_id',$product_id)
                ->where('parent_id','=',null)
                ->get();
            foreach ($data as $key => $cmt){
                $data[$key]['sub_comments'] = $this->getSubCommentByCommentId($cmt['id']);
            }
       return response()->json([
        'success' => true,
        'message'=>  'Tìm thành công',
        'data'=>$data
    ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>'tim du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }
    public function getSubCommentByCommentId($comment_id)
    {
        try {
            $data = CmtRating::with('user:id,name')
                ->where('parent_id',$comment_id)->get();
            return $data;
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
   


}
