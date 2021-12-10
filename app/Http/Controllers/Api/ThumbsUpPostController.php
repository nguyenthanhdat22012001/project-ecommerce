<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ThumbsUpPost;
use Illuminate\Http\Request;

class ThumbsUpPostController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getThumsUpByPost($post_id)
    {         
        try {
            $totalThumbsUp = count(ThumbsUpPost::where('post_id','=',$post_id)->get());

                return response()->json([
                    'success' => true,
                    'message'=>  'lấy dữ liệu thành công',
                    'data'=>[
                        'totalThumbsUp' => $totalThumbsUp
                    ]
                    ]);
            
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage(),
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function thumbsUpPost(Request $request)
    {
        try {
            $data = $request->all();

            ThumbsUpPost::create($data);
            return response()->json([
                'success' => true,
                'message'=>  'Đã like bài viết',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function removeThumbsUpPost(Request $request)
    {
        try {
            $data = $request->all();

            $result = ThumbsUpPost::where('user_id','=',$data['user_id'])
            ->where('post_id','=',$data['post_id'])
            ->first();

            if($result != null){
                $result->delete();
                return response()->json([
                    'success' => true,
                    'message'=>  'xóa thành công',
                    'data'=>$result
                    ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'Dữ liệu không tồn tại'
                ]);
            }
      
            return response()->json([
                'success' => true,
                'message'=>  'Đã like bài viết',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserThumsUp(Request $request)
    {         
        $data = $request->all();
        // return $data;
        try {
 
            $result = ThumbsUpPost::where('user_id','=',$data['user_id'])
            ->where('post_id','=',$data['post_id'])
            ->first();

            if($result != null){
                return response()->json([
                    'success' => true,
                    'message'=>  'User đã like',
                    'data'=>$result
                    ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'User chưa like'
                ]);
            }
      
            return response()->json([
                'success' => true,
                'message'=>  'Đã like bài viết',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage(),
            ],500);
        }
    }
}
