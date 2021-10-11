<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category;
use App\Http\Resources\Admin\Category as AdminCategory;
use App\Models\Category as ModelCategory;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;



class CategoryAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cate=ModelCategory::all();
        $data= new AdminCategory($cate);
//        dd($cate);
//        return response()->json([
//                'title'=>'Category',
//                'message'=>'Thanh cong',
//                'data'=>new AdminCategory($cate),
//                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
//            ]);
        return $this->jsonResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

        $data=$request->all();
        if($request->hasFile('img'));
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
            'data'=>$this->jsonResponse($data)
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
    public function show(Category $category,$id)
    {
        try {
            $data=ModelCategory::find($id);
            return response()->json([
                'title'=>'Show Category',
                'message'=>'Lay du lieu thanh cong',
                'data'=>$this->jsonResponse($data)
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
