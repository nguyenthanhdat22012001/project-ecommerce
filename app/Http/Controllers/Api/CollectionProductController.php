<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CollectionProduct;
use Illuminate\Http\Request;

class CollectionProductController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkUserFavoriteProduct(Request $request)
    {         
        $data = $request->all();
        try {
 
            $result = CollectionProduct::where('user_id','=',$data['user_id'])
            ->where('product_id','=',$data['product_id'])
            ->first();

            if($result != null){
                return response()->json([
                    'success' => true,
                    'message'=>  'User đã thêm vào danh sách yêu thích',
                    'data'=>$result
                    ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'User chưa đã thêm vào danh sách yêu thích'
                ]);
            }

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage(),
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $userHaveProduct = CollectionProduct::where('product_id',$data['product_id'])
            ->where('user_id',$data['user_id'])
            ->first();

            if(empty($userHaveProduct)){
                $result = CollectionProduct::create($data);
                return response()->json([
                    'success' => true,
                    'message'=>  'Đã thêm sản phẩm vào mục yêu thích',
                    'data'=> $result 
                ]);
            }
            return response()->json([
                'success' => true,
                'message'=>  'Đã thêm sản phẩm vào mục yêu thích',
            ]);

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
     * @param  \App\Models\CollectionProduct  $coupon
     * @return \Illuminate\Http\Response
     */
    public function getProductUserFavorite($user_id)
    {
        try {
            $data = CollectionProduct::with('product')->where('user_id',$user_id)->get();

            if($data != null) {
                return response()->json([
                    'success' => true,
                    'message'=>'Lấy sản phẩm thành công',
                    'data'=>$data
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'sản phẩm không tồn tại'
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollectionProduct  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $data = CollectionProduct::where('product_id',$request['product_id'])
            ->where('user_id',$request['user_id'])
            ->first();
            
            if($data != null){
                $data->delete();
                return response()->json([
                    'success' => true,
                    'message'=>  'Đã xóa khỏi danh sách sản phẩm yêu thích của bạn',
                    'data'=>$data
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'sản phẩm không tồn tại'
                ]);
            }

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
}
