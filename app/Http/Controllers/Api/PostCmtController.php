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
                'message'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCommentByPostId($post_id)
    {
        try {
            $data = PostCmt::with('user:id,name')
            ->where('post_id',$post_id)
            ->where('parent_id','=',null)
            ->orderBy('created_at', 'desc')
            ->get();
            foreach ($data as $key => $cmt){
               $data[$key]['sub_comments'] = $this->getSubCommentByCommentId($cmt['id']);
            }
            $totalComment = count(PostCmt::where('post_id',$post_id) ->get());

            return response()->json([
                'success' => true,
                'data'=>[
                    'listComment' => $data ,
                    'totalComment' =>  $totalComment
                ]
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function getSubCommentByCommentId($comment_id)
    {
        try {
            $data = PostCmt::with('user:id,name')
                ->where('parent_id',$comment_id)->get();
            return $data;
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
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

               $newData = PostCmt::create($data);
               $newComment  = PostCmt::with('sub_comments','user')
                                ->where('id',$newData->id)
                                ->first();
                return response()->json([
                    'success' => true,
                    'message'=>  'Bình luận thành công',
                    'data'=>$newComment
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
                'message'=>$e->getMessage()
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

                $postcmt->update($request->all());
                return response()->json([
                    'success' => true,
                    'message'=>  'update thành công',
                    'data'=>$postcmt
                 ]);


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
     * @param  \App\Models\Postcmt  $postcmt
     * @return \Illuminate\Http\Response
     */
    public function destroy($postcmt_id)
    {
        try {
            $data = PostCmt::find($postcmt_id);
                if($data != null){
                    PostCmt::where('parent_id',$data['id'])->delete();
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
                        'message'=>  'Dữ liệu không tồn tại',
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
