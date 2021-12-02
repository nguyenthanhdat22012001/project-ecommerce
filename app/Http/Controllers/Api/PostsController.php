<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CmtRating;
use App\Models\Posts;
use App\Models\PostCmt;
use App\Models\ThumbsUpPost;
use Illuminate\Http\Request;
use App\Http\Requests\PostsStore;
use App\Http\Requests\PostsUpdate;
use Illuminate\Support\Str;

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
            foreach ($data as $key => $post){
                $data[$key]['totalThumb'] = $this->getThumbByPostId($post['id']);
                $data[$key]['totalComment'] = $this->getCommentByPostId($post['id']);
            }
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
    public function getThumbByPostId($post_id)
    {
      return count(ThumbsUpPost::where('post_id',$post_id)->get());
    }
    public function getCommentByPostId($post_id)
    {
        return count(PostCmt::where('post_id',$post_id)->get());
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
            $data['slug'] = Str::slug($data['name'],'-');
            Posts::create($data);
            return response()->json([
                'success' => true,
                'message'=>  'Thêm thành công',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $post = Posts::find($id);

            if($post != null){
                return response()->json([
                    'success' => true,
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$post
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
                'message'=>$e->getMessage()
            ]);
        }
    }

        /**
     * Display post specific
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function getPostBySlug($slug)
    {
        try {
            $post = Posts::where('slug','=',$slug)->first();
            if($post != null){
                $totalComment = PostCmt::where('post_id',$post->id)->get();
                $post['totalComment'] =  count($totalComment);
                $totalThumb = ThumbsUpPost::where('post_id',$post->id)->get();
                $post['totalThumb'] =  count($totalThumb);
                return response()->json([
                    'success' => true,
                    'message'=>'Lay du lieu thanh cong',
                    'data'=>$post
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
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function getTop10PostComment()
    {
        try {
            $query = Posts::withCount('comments')->orderBy('comments_count', 'desc')->limit(10)->get();
            $data = $query;
            foreach ($data as $key => $post){
                $totalThumb = ThumbsUpPost::where('post_id',$post->id)->get();
                $totalComment = PostCmt::where('post_id',$post->id)->get();
                $data[$key]['totalThumb'] = count($totalThumb);
                $data[$key]['totalComment'] = count($totalComment);
            }


            return response()->json([
                'success' => true,
                'message'=>'Lay du lieu thanh cong',
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
                    'success' => true,
                    'message'=>  'update thành công',
                    'data'=>$post
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
                'message'=>$e->getMessage()
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
                    'success' => true,
                    'message'=>  'xóa thành công',
                    'data'=>$post
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
                'message'=>$e->getMessage()
            ]);
        }
    }

}
