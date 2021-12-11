<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CollectionStore;
use Illuminate\Http\Request;

class CollectionStoreController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkUserFollowStore(Request $request)
    {         
        $data = $request->all();
        try {
 
            $result = CollectionStore::where('user_id','=',$data['user_id'])
            ->where('store_id','=',$data['store_id'])
            ->first();

            if($result != null){
                return response()->json([
                    'success' => true,
                    'message'=>  'User đã theo dõi cửa hàng',
                    'data'=>$result
                    ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'User chưa theo dõi cửa hàng'
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
            $userHaveCoupon = CollectionStore::where('store_id',$data['store_id'])
            ->where('user_id',$data['user_id'])
            ->first();

            if(empty($userHaveCoupon)){
                $result = CollectionStore::create($data);
                return response()->json([
                    'success' => true,
                    'message'=>  'Đã thêm vào danh sách cửa hàng theo dõi',
                    'data'=> $result 
                ]);
            }
            return response()->json([
                'success' => true,
                'message'=>  'Đã thêm vào danh sách cửa hàng theo dõi',
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
     * @param  \App\Models\CollectionStore  $coupon
     * @return \Illuminate\Http\Response
     */
    public function getStoreUserFollow($user_id)
    {
        try {
            $data = CollectionStore::with('store')->where('user_id',$user_id)->get();

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
                    'message'=>'Cửa hàng không tồn tại'
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
     * @param  \App\Models\CollectionStore  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $data = CollectionStore::where('store_id',$request['store_id'])
            ->where('user_id',$request['user_id'])
            ->first();

            if($data != null){
                $data->delete();
                return response()->json([
                    'success' => true,
                    'message'=>  'Đã xóa khỏi danh sách cửa hàng theo dõi',
                    'data'=>$data
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'Cửa hàng không tồn tại'
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
