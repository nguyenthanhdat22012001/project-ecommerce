<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStore;
use App\Http\Requests\StoreUpdate;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Store::all();
            foreach ($data as $item) {
                $revenueMonth = Order::where('store_id','=',$item['id'])
                ->whereDate('updated_at','like','%'.Carbon::now()->format('Y-m').'%')
                ->where('status','=',4)
                ->sum('totalprice');

                $item['revenueMonth'] = $revenueMonth;
            }

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
    public function store(StoreStore $request)
    {

        try {
            $data = $request->all();
            $data['slug'] = Str::slug($data['name'],'-');
            if($data['img']) {
                $image = $data['img'];
                $name = rand(10,1000).time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($image)->save(public_path('images/').$name);
//                $name = $image->getClientOriginalName();

                $data['img'] = 'http://'.$_SERVER['HTTP_HOST']. '/images/'.$name;
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>  'Không có file ảnh',
                ]);
            }
            Store::create($data);
            return response()->json([
                'success' => true,
                'message'=>  'Thêm thành công',
                'data' =>  $data
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
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show($store)
    {
        try {
            $data = Store::find($store);
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
                'message'=>'Lay du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdate $request, $store)
    {
        try {
            $data = Store::find($store);
            if($data != null){
                $update =  $request->all();
                if(isset($update['img']) && $update['img'] !=  $data['img']) {
                    if(file_exists(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $data['img'] ))){
                        unlink(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $data['img'] ));
                    }
                    $image = $request['img'];
                    $name = rand(10,1000).time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                    \Image::make($image)->save(public_path('images/').$name);
                    $update['img'] = 'http://'.$_SERVER['HTTP_HOST']. '/images/'.$name;
                }
                $update['slug'] = Str::slug($update['name'],'-');
                $data->update($update);
                return response()->json([
                    'success' => true,
                    'message'=>  'Cập nhật thông tin cửa hàng thành công',
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
                'message'=>'update du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($store)
    {
        try {
            $data = Store::find($store);
            if($data != null){
                if(file_exists(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $data['img'] ))){
                    unlink(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $data['img'] ));
                }
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
                    'message'=>'Dữ liệu không tồn tại'
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
