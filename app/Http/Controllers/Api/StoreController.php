<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStore;
use App\Http\Requests\StoreUpdate;

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
            if($data['img']) {
                $image = $data['img'];
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($image)->save(public_path('images/').$name);
                $data['img'] = '/images/'.$name;
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
                if($data['img']) {
                    if(file_exists(public_path().$data['img'])){
                        unlink(public_path().$data['img']);
                    }
                    $image = $data['img'];
                    $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                    \Image::make($image)->save(public_path('images/').$name);
                    $data['img'] = '/images/'.$name;
                }
                $data->update($request->all());
                return response()->json([
                    'success' => true,
                    'message'=>  'Sửa thành công',
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
                if(file_exists(public_path().$data['img'])){
                    unlink(public_path().$data['img']);
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
