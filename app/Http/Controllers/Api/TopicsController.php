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
                'title'=>'get all topics',
                'message'=>  'lấy dữ liệu thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'get all topics',
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
                'title'=>'add topics',
                'message'=>  'Thêm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'add topics',
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
                    'title'=>'Show topics',
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$topics
                ]);
            }
            else{
                return response()->json([
                    'title'=>'delete cmt',
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$topics
                    ]);
            }
            
        }catch (\Exception $e){
            return response()->json([
                'title'=>'Show topics',
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
                    'title'=>'update topics',
                    'message'=>  'update thành công',
                    'data'=>$topics
                 ]);
            }
            else{
                return response()->json([
                    'title'=>'delete cmt',
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$topics
                    ]);
            }
           
    }catch (\Exception $e){
        return response()->json([
            'title'=>'update topics',
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
                    'title'=>'delete cmt',
                    'message'=>  'xóa thành công',
                    'data'=>$topics
                    ]);
            }
            else{
                return response()->json([
                    'title'=>'delete cmt',
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$topics
                    ]);
            }
            
        }catch (\Exception $e){
            return response()->json([
                'title'=>'delete cmt',
                'message'=>'xoa du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }
}
