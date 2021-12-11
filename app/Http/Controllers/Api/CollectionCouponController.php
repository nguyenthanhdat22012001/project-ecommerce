<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CollectionCoupon;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CollectionCouponController extends Controller
{

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
            $userHaveCoupon = CollectionCoupon::where('coupon_id',$data['coupon_id'])
            ->where('user_id',$data['user_id'])
            ->first();

            if(empty($userHaveCoupon)){
                $result = CollectionCoupon::create($data);
                return response()->json([
                    'success' => true,
                    'message'=>  'Đã thêm mã giảm giá',
                    'data'=> $result 
                ]);
            }
            return response()->json([
                'success' => true,
                'message'=>  'Đã thêm mã giảm giá',
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
     * @param  \App\Models\CollectionCoupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function getCouponOfUser($user_id)
    {
        try {
            $data = CollectionCoupon::with('coupon')->where('user_id',$user_id)->get();

            if($data != null) {
                return response()->json([
                    'success' => true,
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$data
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'Dữ liệu không tồn tại'
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
     * @param  \App\Models\CollectionCoupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($coupon)
    {
        try {
            $data = CollectionCoupon::find($coupon);
            if($data != null){
                $data->delete();
                return response()->json([
                    'success' => true,
                    'message'=>  'Đã xóa khỏi danh sách voucher của bạn',
                    'data'=>$data
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'Dữ liệu không tồn tại'
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
