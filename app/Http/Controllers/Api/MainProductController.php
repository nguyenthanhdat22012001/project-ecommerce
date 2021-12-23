<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order_detail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\CollectionStore;
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
            $data = Product::withCount('order')
            ->with('attributes','rating','brand','cate','store')
            ->where('slug',$slug)
            ->first();
            $sumStars = CmtRating::where('product_id',$data->id)->avg('point');
            $data->totalRating = floor($sumStars);
            $totalComment = count(CmtRating::where('product_id',$data->id)->get());
            $data->totalComment = $totalComment;
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
            $store['totalFollow']  = count(CollectionStore::where('store_id',$store['id'])->get());
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
            $data = Product::where('hide','0')->whereRaw("cate_id = ". $id )->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->get();
        }
        if($key == 'brand'){
            $data = Product::where('hide','0')->whereRaw("brand_id = ". $id )->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->get();
        }
        if($key == 'store'){
            $data = Product::whereRaw("store_id = ". $id )->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->get();
        }
        // $result = $data->get();
        foreach (  $data  as $item) {
            $sumStars = CmtRating::where('product_id',$item->id)->avg('point');
             $item->totalRating = floor($sumStars);
             $totalComment = count(CmtRating::where('product_id',$item->id)->get());
             $item->totalComment = $totalComment;
        }
            return response()->json([
                'success' => true,
                'message'=>  'lấy dữ liệu thành công',
                'data'=> $data
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
                'message'=>$e->getMessage(),
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
            $now = date('Y-m-d');
            if($store_id == 0){
                $data = Coupon::where('store_id',null)->orderBy('id','DESC')->where('date_end'.'>='.$now)->get();

                    return response()->json([
                        'success' => true,
                        'message'=>  'Tìm thành công',
                        'data'=>$data
                    ]);
            }
            else{
                $data = Coupon::where('store_id',$store_id)->orderBy('id','DESC')->where('date_end'.'>='.$now)->get();

                    return response()->json([
                        'success' => true,
                        'message'=>  'Tìm thành công',
                        'data'=>$data
                    ]);
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
            $data = Product::where('hide','0')->where('discount < price')->with('store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->orderBy('discount','desc')->limit(8)->get();
            foreach (  $data  as $item) {
                $sumStars = CmtRating::where('product_id',$item->id)->avg('point');
                 $item->totalRating = floor($sumStars);
                 $totalComment = count(CmtRating::where('product_id',$item->id)->get());
                 $item->totalComment = $totalComment;
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
    public function getTopBuyProduct()
    {
        try {
            $data = Product::where('hide','0')->withCount('order')->orderBy('order_count', 'desc')->with('store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->limit(9)->get();
            foreach (  $data  as $item) {
                $sumStars = CmtRating::where('product_id',$item->id)->avg('point');
                 $item->totalRating = floor($sumStars);
                 $totalComment = count(CmtRating::where('product_id',$item->id)->get());
                 $item->totalComment = $totalComment;
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
            $data = Product::where('hide','0')->with('rating')->get();
            foreach ( $data  as $item) {
                $sumStars = CmtRating::where('product_id',$item->id)->avg('point');
                $item->totalRating = floor($sumStars);
            }
            $data = $data->sortByDesc('totalRating');
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
            $data = Store::where('hide','0')->withCount('follow')->orderBy('follow_count', 'desc')->limit(5)->get();
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
          $data=Product::where('hide','0')->with('rating','store:id,name,slug','cate:id,name,slug','brand:id,name,slug')->orderBy('created_at','DESC')->get();
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
