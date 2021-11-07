<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use App\Http\Requests\PostsStore;
use App\Http\Requests\PostsUpdate;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Posts::all();
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
    public function store(PostsStore $request)
    {
        try {
            $data = $request->all();
            Posts::create($data);
            return response()->json([
                'title'=>'add post',
                'message'=>  'Thêm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'add post',
                'message'=>'them that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        try {
            $post = Posts::find($post);
            if($post != null){
                return response()->json([
                    'title'=>'Show post',
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$post
                ]);
            }
            else{
                return response()->json([
                    'title'=>'Show post',
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$post
                    ]);
            }
            
        }catch (\Exception $e){
            return response()->json([
                'title'=>'Show post',
                'message'=>'Lay du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsUpdate $request, $post)
    {
        try {
            $post = Posts::find($post);
            if($post != null){
                $post->update($request->all());
                return response()->json([
                    'title'=>'update post',
                    'message'=>  'update thành công',
                    'data'=>$post
                 ]);
            }
            else{
                return response()->json([
                    'title'=>'update post',
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$post
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($post)
    {
        try {
            $post = Posts::find($post);
            if($post != null){
                $post->delete();
                return response()->json([
                    'title'=>'delete post',
                    'message'=>  'xóa thành công',
                    'data'=>$post
                    ]);
            }
            else{
                return response()->json([
                    'title'=>'delete post',
                    'message'=>  'Dữ liệu không tồn tại',
                    'data'=>$post
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
