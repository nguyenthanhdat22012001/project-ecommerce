<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CmtRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            if($data['parent_id']== null){
                if($data['point']!= null){
                    CmtRating::create($data);
                    return response()->json([
                        'success' => true,
                        'message'=>  'Comment thành công',
                        'data'=>$data
                    ]);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message'=>'Chưa chấm điểm',
                        'data'=>$data
                    ]);
                }
            }
            else{
                if($data['point'] == null){
                    CmtRating::create($data);
                    return response()->json([
                        'success' => true,
                        'message'=>  'Reply thành công',
                        'data'=>$data
                    ]);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message'=>  'Bình luận con không chấm điểm',
                        'data'=>$data
                    ]);
                }

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
                    'success' => false,
                    'message'=>'Dữ liệu không tồn tại',
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
     * @param  \App\Models\CmtRating  $cmtRating
     * @return \Illuminate\Http\Response
     */
    public function destroy($cmtRating_id)
    {
        //
        try {
            $cmtRating = CmtRating::find($cmtRating_id);
            if($cmtRating != null){
                $query = CmtRating::query();
                $cmtReply = $query->whereRaw("parent_id = ". $cmtRating_id )->get('id');
                foreach ($cmtReply as $rep){
                    CmtRating::find($rep['id'])->delete();
                }
                $cmtRating->delete();
                return response()->json([
                    'success' => true,
                    'message'=>  'xóa thành công',
                    'data'=>$cmtRating
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
