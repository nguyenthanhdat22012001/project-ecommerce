<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category;
use App\Http\Resources\Admin\Category as AdminCategory;
use App\Models\Category as ModelCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
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
        $cate=ModelCategory::all();
        $data= new AdminCategory($cate);
        return response()->json([
            'title'=>'Add Category',
            'message'=>'Them thanh cong',
            'data'=>$data
        ]);
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
            $destination_path='public/images/';
            $image=$request->file('img');
            $image_name=$image->getClientOriginalName();
            $path=$image->storeAs($destination_path,$image_name);
            $data['img']=$image_name;
        }
        $getSlug=$request->slug;
        if($getSlug!=''){
            $data['slug']=Str::slug($getSlug);

        }
        else $data['slug']=Str::slug($request->name);
        ModelCategory::create($data);
        return response()->json([
            'title'=>'Add Category',
            'message'=>'Them thanh cong',
            'data'=>$data
        ]);
        }catch (\Exception $e) {
            return response()->json([
                'title'=>'Add Category',
                'message'=>'Them that bai',
                'errors'=>$e->getMessage()
            ]);
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
                'title'=>'Show Category',
                'message'=>'Lay du lieu thanh cong',
                'data'=>$category
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'Show Category',
                'message'=>'Lay du lieu that bai',
                'errors'=>$e->getMessage()
            ]);
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
                $destination_path = 'public/images/';
                $image = $request->file('img');
                $image_name = $image->getClientOriginalName();
                $path = $image->storeAs($destination_path, $image_name);
                $data['img'] = $image_name;
            }
                    //Xu ly slug
            $getSlug = $request->slug;
            if ($getSlug != '') {
                $data['slug'] = Str::slug($getSlug);

            } else $data['slug'] = Str::slug($request->name);

           $category->update($data);

            return response()->json([
                'title'=>'Update Category',
                'message'=>'Update thanh cong',
                'data'=>$data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'title'=>'Update Category',
                'message'=>'Update that bai',
                'errors'=>$e->getMessage()
            ]);
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
           $delete= $category->delete();
            return response()->json([
                'title'=>'Delete Category',
                'message'=>'Delete thanh cong',
                'data'=>$category
            ]);
        }catch (\Exception $e){

            return response()->json([
                'title'=>'Delete Category',
                'message'=>'Delete that bai',
                'errors'=>$e->getMessage()
            ]);
        }
    }
}
