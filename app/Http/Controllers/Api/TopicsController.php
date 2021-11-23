<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topics;
use Illuminate\Http\Request;
use App\Http\Requests\TopicsStore;
use App\Http\Requests\TopicsUpdate;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Topics::all();
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
    public function store(TopicsStore $request)
    {
        try {
            $data = $request->all();
            Topics::create($data);
            return response()->json([
                'success' => true,
                'message'=>  'Thêm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>'them that bai',
                'errors'=>$e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Topics  $topics
     * @return \Illuminate\Http\Response
     */
    public function show($topics)
    {
        try {
            $topics = Topics::find($topics);
            if($topics != null){
                return response()->json([
                    'success' => true,
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$topics
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
     * @param  \App\Models\Topics  $topics
     * @return \Illuminate\Http\Response
     */
    public function update(TopicsUpdate $request,$topics)
    {
        try {
            $topics = Topics::find($topics);
            if($topics != null){
                $topics->update($request->all());
                return response()->json([
                    'success' => true,
                    'message'=>  'update thành công',
                    'data'=>$topics
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
     * @param  \App\Models\Topics  $topics
     * @return \Illuminate\Http\Response
     */
    public function destroy($topics)
    {
        try {
            $topics = Topics::find($topics);
            if($topics != null){
                $topics->delete();
                return response()->json([
                    'success' => true,
                    'message'=>  'xóa thành công',
                    'data'=>$topics
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
