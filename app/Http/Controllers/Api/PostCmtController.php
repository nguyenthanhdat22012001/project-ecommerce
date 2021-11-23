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
    public function store(PostCmtStore $request)
    {
        try {
            $data = $request->all();
            if($data['parent_id']== null){
                PostCmt::create($data);
                return response()->json([
                    'success' => true,
                    'message'=>  'comment thành công',
                    'data'=>$data
                ]);
            }
            else{
                PostCmt::create($data);
                return response()->json([
                    'success' => true,
                    'message'=>  'reply thành công',
                    'data'=>$data
                ]);
            }

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
     * @param  \App\Models\Postcmt  $postcmt
     * @return \Illuminate\Http\Response
     */
    public function show($postcmt)
    {
        try {
            $postcmt = PostCmt::find($postcmt);
            if($postcmt != null){
                return response()->json([
                    'success' => true,
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$postcmt
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
                    'success' => true,
                    'message'=>  'update thành công',
                    'data'=>$postcmt
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
    public function destroy($postcmt_id)
    {
        try {
            $postcmt = PostCmt::find($postcmt_id);
            if($postcmt != null){
                $query = PostCmt::query();
                $postReply = $query->whereRaw("parent_id = ". $postcmt_id )->get('id');
                foreach ($postReply as $rep){
                    PostCmt::find($rep['id'])->delete();
                }
                $postcmt->delete();
                return response()->json([
                    'success' => true,
                    'message'=>  'xóa thành công',
                    'data'=>$postcmt
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
                'message'=>'xoa du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }
}
