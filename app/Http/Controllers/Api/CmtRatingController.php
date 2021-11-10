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
    public function store(CommentStore $request)
    {
        try {
            $data = $request->all();
            CmtRating::create($data);
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
     * @param  \App\Models\CmtRating  $cmtRating
     * @return \Illuminate\Http\Response
     */
    public function show($cmtRating)
    {
        try {
            $data = CmtRating::find($cmtRating);
            if($data != null){
                return response()->json([
                    'success' => true,
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$data
                ]);
            }
            else{
                return response()->json([
                    'success' => true,
                    'message'=>'Dữ liệu không tồn tại',
                    'data'=>$data
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
     * @param  \App\Models\CmtRating  $cmtRating
     * @return \Illuminate\Http\Response
     */
    public function update(CommentUpdate $request, $cmtRating)
    {
        
        try {
            $cmtRating = CmtRating::find($cmtRating);
            if($cmtRating != null) {
                $cmtRating->update($request->all());
                return response()->json([
                    'success' => true,
                    'message'=>  'update thành công',
                    'data'=>$cmtRating
                ]);
            }
            else{
                return response()->json([
                    'success' => true,
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$cmtRating
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
     * @param  \App\Models\CmtRating  $cmtRating
     * @return \Illuminate\Http\Response
     */
    public function destroy($cmtRating)
    {
        //
        try {
            $cmtRating = CmtRating::find($cmtRating);
            if($cmtRating != null){
                $cmtRating->delete();
                return response()->json([
                    'success' => true,
                    'message'=>  'xóa thành công',
                    'data'=>$cmtRating
                ]);
            }
            else{
                return response()->json([
                    'success' => true,
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$cmtRating
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
