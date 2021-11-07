<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostCmt;
use Illuminate\Http\Request;
use App\Http\Requests\PostCmtStore;
use App\Http\Requests\PostCmtUpdate;

class PostCmtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = PostCmt::all();
            return response()->json([
                'title'=>'get all Posts',
                'message'=>  'lấy dữ liệu thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'get all Posts',
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
    public function store(PostCmtStore $request)
    {
        try {
            $data = $request->all();
            PostCmt::create($data);
            return response()->json([
                'title'=>'add post comment',
                'message'=>  'Thêm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'add post comment',
                'message'=>'them that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Postcmt  $postcmt
     * @return \Illuminate\Http\Response
     */
    public function show($postcmt)
    {
        try {
            $postcmt = PostCmt::find($postcmt);
            if($postcmt != null){
                return response()->json([
                    'title'=>'Show post comment',
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$postcmt
                ]);
            }
            else{
                return response()->json([
                    'title'=>'Show post comment',
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$postcmt
                    ]);
            }
            
        }catch (\Exception $e){
            return response()->json([
                'title'=>'Show post comment',
                'message'=>'Lay du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Postcmt  $postcmt
     * @return \Illuminate\Http\Response
     */
    public function update(PostCmtUpdate $request, $postcmt)
    {
        try {
            $postcmt = PostCmt::find($postcmt);
            if($postcmt != null){
                $postcmt->update($request->all());
                return response()->json([
                    'title'=>'update post',
                    'message'=>  'update thành công',
                    'data'=>$postcmt
                 ]);
            }
            else{
                return response()->json([
                    'title'=>'update post',
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$postcmt
                    ]);
            }
           
        }catch (\Exception $e){
            return response()->json([
                'title'=>'update post',
                'message'=>'update du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Postcmt  $postcmt
     * @return \Illuminate\Http\Response
     */
    public function destroy($postcmt)
    {
        try {
            $postcmt = PostCmt::find($postcmt);
            if($postcmt != null){
                $postcmt->delete();
                return response()->json([
                    'title'=>'delete post',
                    'message'=>  'xóa thành công',
                    'data'=>$postcmt
                    ]);
            }
            else{
                return response()->json([
                    'title'=>'delete post',
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$postcmt
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
