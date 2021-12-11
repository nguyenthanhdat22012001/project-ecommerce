<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order_detail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\CmtRating;
use App\Models\Category;

class MainProductController extends Controller
{
        /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function getProductBySlug($slug)
    {
        try {
            $data = Product::where('slug',$slug)->with('attributes','rating','brand','cate','store')->first();
            $data['listimg'] = explode(",", $data['listimg']);
            if($data != null){
                return response()->json([
                    'success' => true,
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$data
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'sản phẩm không tồn tại',
                ]);
            }

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function getProductByCategorySlug($slug)
    {
        try {
            $category = Category::where('slug',$slug)->first();
            if (!empty($category)) {
                $products = Product::where('cate_id','=',$category->id)->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->get();

                    return response()->json([
                        'success' => true,
                        'message'=>'Lay du lieu thanh cong',
                        'data'=>[
                            'category' =>  $category,
                            'products' =>  $products,
                        ]
                    ]);

            }else{
                return response()->json([
                    'success' => false,
                    'message'=>'Danh mục này không tồn tại',
                ]);
            }

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function getProductByStoreSlug($slug)
    {
        try {
            $store = Store::where('slug',$slug)->first();
            if (!empty($store)) {
                $products = Product::where('store_id','=',$store->id)->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->get();

                    return response()->json([
                        'success' => true,
                        'message'=>'Lay du lieu thanh cong',
                        'data'=>[
                            'store' =>  $store,
                            'products' =>  $products,
                        ]
                    ]);

            }else{
                return response()->json([
                    'success' => false,
                    'message'=>'cửa hàng này không tồn tại',
                ]);
            }

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_product_by( $key,$id)
    {
        try {
//            $query = query();
        //     $s = $request->input('search');
        //    $query->whereRaw("name LIKE '%". $s ."%'" )->orWhereRaw("description LIKE '%". $s ."%'" );
        if($key == 'cate'){
            $data = Product::whereRaw("cate_id = ". $id )->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->get();
        }
        if($key == 'brand'){
            $data = Product::whereRaw("brand_id = ". $id )->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->get();
        }
        if($key == 'store'){
            $data = Product::whereRaw("store_id = ". $id )->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->get();
        }
            foreach($data as $key => $value){
                $point = 0;
                foreach ($value['rating'] as $item){
                    $point += $item['point'];
                }
                if($point > 0){
                    $point = $point/count($value['rating']);
                }
                else{
                    $point = 0;
                }
                $data[$key]['point']=$point;
            }
            return response()->json([
                'success' => true,
                'message'=>  'lấy dữ liệu thành công',
                'data'=>$data
        ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function get_comment_by_product($product_id)
    {
        try {
            $data = CmtRating::with('user:id,name')
                ->where('product_id',$product_id)
                ->where('parent_id',null)
                ->orderBy('created_at', 'desc')
                ->get();
            foreach ($data as $key => $cmt){
                $data[$key]['sub_comments'] = $this->getSubCommentByCommentId($cmt['id']);
            }
            $totalComment = count(CmtRating::where('product_id',$product_id) ->get());

            return response()->json([
                'success' => true,
                'message'=>  'Tìm thành công',
                'data'=>[
                    'listComment' => $data ,
                    'totalComment' =>  $totalComment
                ]
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
    public function getCoupon($store_id)
    {
        try {
            if($store_id == 0){
                $data = Coupon::where('store_id',null)->get();
                if(count($data)>0){
                    return response()->json([
                        'success' => true,
                        'message'=>  'Tìm thành công',
                        'data'=>$data
                    ]);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message'=>  'Trống',
                    ]);
                }
            }
            else{
                $data = Coupon::where('store_id',$store_id)->get();
                if(count($data)>0){
                    return response()->json([
                        'success' => true,
                        'message'=>  'Tìm thành công',
                        'data'=>$data
                    ]);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message'=>  'Trống',
                    ]);
                }

            }
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function getTopSalesProduct()
    {
        try {
            $data = Product::with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->orderBy('discount','desc')->limit(9)->get();
            return response()->json([
                'success' => true,
                'message'=>  'Tìm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function getTopBuyProduct()
    {
        try {
            $data = Product::withCount('order')->orderBy('order_count', 'desc')->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->limit(9)->get();
            foreach($data as $key => $value){
                $point = 0;
                foreach ($value['rating'] as $item){
                    $point += $item['point'];
                }
                if($point > 0){
                    $point = $point/count($value['rating']);
                }
                else{
                    $point = 0;
                }
                $data[$key]['point']=$point;
            }
            return response()->json([
                'success' => true,
                'message'=>  'Tìm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function getTopProductRating()
    {
        try {
            $data = Product::with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->get();
            foreach($data as $key => $value){
                $point = 0;
              foreach ($value['rating'] as $item){
                  $point += $item['point'];
              }
              if($point > 0){
                  $point = $point/count($value['rating']);
              }
              else{
                  $point = 0;
              }
            $data[$key]['point']=$point;
            }
            $data = $data->sortByDesc('point');
            return response()->json([
                'success' => true,
                'message'=>  'Tìm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function getTopStoreFollow()
    {
        try {
            $data = Store::withCount('follow')->orderBy('follow_count', 'desc')->limit(5)->get();
            return response()->json([
                'success' => true,
                'message'=>  'Tìm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function getAllProduct()
    {
        try {
          $data=Product::with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->orderBy('created_at','DESC')->get();
            foreach($data as $key => $value){
                $point = 0;
                foreach ($value['rating'] as $item){
                    $point += $item['point'];
                }
                if($point > 0){
                    $point = $point/count($value['rating']);
                }
                else{
                    $point = 0;
                }
                $data[$key]['point']=$point;
            }
            return response()->json([
                'success' => true,
                'message'=>  'Tìm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
}
