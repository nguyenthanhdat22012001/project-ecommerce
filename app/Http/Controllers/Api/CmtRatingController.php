<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CmtRating;
use Illuminate\Http\Request;
use App\Http\Requests\CommentStore;
use App\Http\Requests\CommentUpdate;

class CmtRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       try {
        $data = CmtRating::all();
        return response()->json([
            'title'=>'get all comment',
            'message'=>  'lấy dữ liệu thành công',
            'data'=>$data
        ]);
    }catch (\Exception $e){
        return response()->json([
            'title'=>'get all comment',
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
    public function store(CommentStore $request)
    {
        try {
            $data = $request->all();
            CmtRating::create($data);
            return response()->json([
                'title'=>'add comment',
                'message'=>  'Thêm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'add comment',
                'message'=>'them that bai',
                'errors'=>$e->getMessage()
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CmtRating  $cmtRating
     * @return \Illuminate\Http\Response
     */
    public function show($cmtRating)
    {
        try {
            return response()->json([
                'title'=>'Show comment',
                'message'=>'Lay du lieu thanh cong',
                'data'=>CmtRating::find($cmtRating)
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'Show comment',
                'message'=>'Lay du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CmtRating  $cmtRating
     * @return \Illuminate\Http\Response
     */
    public function update(CommentUpdate $request, $cmtRating)
    {
        
        try {
            $cmtRating = CmtRating::find($cmtRating);
            $cmtRating->update($request->all());
            return response()->json([
                'title'=>'update cmt',
                'message'=>  'update thành công',
                'data'=>$cmtRating
        ]);
    }catch (\Exception $e){
        return response()->json([
            'title'=>'update cmt',
            'message'=>'update du lieu that bai',
            'errors'=>$e->getMessage()
        ]);
    }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CmtRating  $cmtRating
     * @return \Illuminate\Http\Response
     */
    public function destroy($cmtRating)
    {
        //
        try {
            $cmtRating = CmtRating::find($cmtRating);
            $cmtRating->delete();
            return response()->json([
                'title'=>'delete cmt',
                'message'=>  'xóa thành công',
                'data'=>$cmtRating
        ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'delete cmt',
                'message'=>'xoa du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }
    
}
