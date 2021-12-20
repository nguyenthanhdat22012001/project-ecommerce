<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Payment::all();
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
            Payment::create($data);
            return response()->json([
                'success' => true,
                'message'=>  'Thêm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Payment::find($id);
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
                    'message'=>'Dữ liệu không tồn tại',
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Payment::find($id);
            if($data != null){
            $update =  $request->all();
            $data->update( $update);
            return response()->json([
                'success' => true,
                'message'=>  'Sửa thành công',
                'data'=>$data
            ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>  'Dữ liệu không tồn tại',
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
     * @param  \App\Models\Payment  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Payment::find($id);
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
                    'success' => false,
                    'message'=>  'Dữ liệu không tồn tại',
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
