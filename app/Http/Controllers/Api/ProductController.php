<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Http\Requests\ProductStore;
use App\Http\Requests\ProductUpdate;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Product::all();
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
    public function store(ProductStore $request)
    {
        try {
        $data = $request->all();
        $data['slug'] = Str::slug($data['name'],'-');
        $listimages=array();
        if($data['img']) {
            $image = $data['img'];
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/').$name);
            $data['img'] = '/images/'.$name;
        }
        else{
            return response()->json([
                'success' => false,
                'message'=>  'Không có file ảnh'
            ]);
        }
            if($data['listimg']) {
                foreach ($data['listimg'] as $list){
                    $image = $list;
                    $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                    \Image::make($image)->save(public_path('images/').$name);
                    $listimages[] = '/images/'.$name;
                }
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>  'Không có list ảnh'
                ]);
            }
        $listimages =  implode(",",$listimages);
        $data['listimg'] = $listimages;
        $product = Product::create([
            'store_id'=>$data['store_id'],
            'cate_id'=>$data['cate_id'],
            'brand_id'=>$data['brand_id'],
            'name'  => $data['name'],
            'description'=>$data['description'],
            'shortdescription'=>$data['shortdescription'],
            'hide'=>$data['hide'],
            'img'=>$data['img'],
            'listimg'=>$data['listimg'],
            'slug'=>$data['slug'],
            'sort'=>$data['sort'],
        ]);
        if(count($data['name_att'])>= 1){
            foreach ($data['name_att'] as $key => $att){
                Attribute::create([
                    'product_id'=>$product['id'],
                    'name' => $data['name_att'][$key],
                    'style'=>$data['style'][$key],
                    'quantity'=>$data['quantity'][$key],
                    'price'=>$data['price'][$key],
                    'discount'=>$data['discount'][$key]
                ]);
            }

        }
        else{
            return response()->json([
                'success' => false,
                'message'=>  'Nhập tối thiểu 1 thuộc tính'
            ]);
        }

        return response()->json([
            'success' => true,
            'message'=>  'Thêm thành công',
            'data'=>$data
        ]);
    }catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message'=>'Them that bai'
        ]);
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        try {
            $data = Product::find($product);
            $data['listimg'] = explode(",", $data['listimg']);
            $data->attribute;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdate $request, $product)
    {
        try {
                $data = Product::find($product);
                if($data != null){
                    $update =  $request->all();
                    if($update['img']) {
                        if(file_exists(public_path().$data['img'])){
                            unlink(public_path().$data['img']);
                        }
                        $image = $request['img'];
                        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                        \Image::make($image)->save(public_path('images/').$name);
                        $update['img'] = '/images/'.$name;
                    }
                    $update['slug'] = Str::slug($update['name'],'-');
                    $data->update($update);
                    return response()->json([
                        'success' => true,
                        'message'=>  'update thành công',
                        'data'=>$data
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
    public function destroy(Product $product)
    {
        try {
                $data = Product::find($product);
                if($data != null){
                    if(file_exists(public_path().$data['img'])){
                        unlink(public_path().$data['img']);
                    }
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
                        'message'=>'Dữ liệu không tồn tại'
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
