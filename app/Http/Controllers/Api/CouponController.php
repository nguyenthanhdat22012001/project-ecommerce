<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Requests\CouponStore;
use App\Http\Requests\CouponUpdate;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Coupon::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponStore $request)
    {
        $data = $request->all();
        Coupon::create($data);
        return response()->json([
            'message'=>  'Thêm thành công',
            'data'=>$data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        try {
            return response()->json([
                'title'=>'Show Category',
                'message'=>'Lay du lieu thanh cong',
                'data'=>$coupon
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
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(CouponUpdate $request, Coupon $coupon)
    {
        $coupon->update($request->all());
        return response()->json([
            'message'=>  'Sửa thành công',
            'data'=>$coupon
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return response()->json([
            'message'=>  'Xóa thành công',
            'data'=>$coupon
        ]);
    }
}
