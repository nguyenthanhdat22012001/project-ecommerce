<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category;
use App\Http\Resources\Admin\Category as AdminCategory;
use App\Models\Category as ModelCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use App\Http\Requests\Category as ValidateCategory;


class CategoryAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $cate = ModelCategory::all();
        $data = new AdminCategory($cate);

        return response()->json([
            'success' => true,
            'title' => 'Add Category',
            'message' => 'Them thanh cong',
            'data' => $data
        ], Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function store(ValidateCategory $request)
    {
        try {
        $data=$request->all();
        if($request->hasFile('img'))
        {
            $image=$request->file('img');
            $data['img']=ImageProcess($image); //ham helper xu ly file anh
        }
        $getSlug=$request->slug;
        if($getSlug!=''){
            $slug=Str::slug($getSlug);
//            $data['slug']=Str::slug($getSlug);
        }
        else $slug=Str::slug($request->name);
        $data['slug']=$slug;
        //Kiem tra slug ton tai hay chua
//        $checkSlug=ModelCategory::where('slug','like',$slug)->first();
//        if($checkSlug!=''){
//
//        }
        ModelCategory::create($data);
        return response()->json([
            'success'=>true,
            'title'=>'Add Category',
            'message'=>'Them thanh cong',
            'data'=>$data
        ],Response::HTTP_OK);
        }catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'title'=>'Add Category',
                'message'=>'Them that bai',
                'errors'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function show(ModelCategory $category)
    {
        try {
            return response()->json([
                'success'=>true,
                'title'=>'Show Category',
                'message'=>'Lay du lieu thanh cong',
                'data'=>$category
            ],Response::HTTP_OK);
        }catch (\Exception $e){
            return response()->json([
                'success'=>false,
                'title'=>'Show Category',
                'message'=>'Lay du lieu that bai',
                'errors'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, ModelCategory $category)
    {
//        $category=ModelCategory::findOrFail($id);
        try {
            $data = $request->all();
            //Xu ly file img ->public/storage/images
            if ($request->hasFile('img'))
            {
                $image = $request->file('img');
                $data['img'] = ImageProcess($image); //ham helper xu ly file anh
            }
                    //Xu ly slug
            $getSlug = $request->slug;
            if ($getSlug != '') {
                $data['slug'] = Str::slug($getSlug);

            } else $data['slug'] = Str::slug($request->name);
            //Update
           $category->update($data);

            return response()->json([
                'success'=>true,
                'title'=>'Update Category',
                'message'=>'Update thanh cong',
                'data'=>$data
            ],Response::HTTP_OK);
        }catch (\Exception $e){
            return response()->json([
                'success'=>false,
                'title'=>'Update Category',
                'message'=>'Update that bai',
                'errors'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return JsonResponse
     */
    public function destroy(ModelCategory $category)
    {
        try{
           $category->delete();
            return response()->json([
                'success'=>true,
                'title'=>'Delete Category',
                'message'=>'Delete thanh cong',
                'data'=>$category
            ],Response::HTTP_OK);
        }catch (\Exception $e){

            return response()->json([
                'success'=>false,
                'title'=>'Delete Category',
                'message'=>'Delete that bai',
                'errors'=>$e->getMessage()
            ],500);
        }
    }
}
