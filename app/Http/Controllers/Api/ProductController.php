<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\CmtRating;
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
            $name = rand(10,100).time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/').$name);
            $data['img'] =$_SERVER['HTTP_HOST']. '/images/'.$name;
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
                   $listimages[] = $_SERVER['HTTP_HOST']. '/images/'.$name;
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
            'price'  => $data['price'],
            'description'=>$data['description'],
            'shortdescription'=>$data['shortdescription'],
            'hide'=>$data['hide'],
            'img'=>$data['img'],
            'listimg'=>$data['listimg'],
            'price'=>$data['price'],
            'discount'=>$data['discount'],
            'slug'=>$data['slug']
        ]);
        if(count($data['attributes'])>= 1){
            foreach ($data['attributes'] as $item){
                Attribute::create([
                    'product_id'=>$product['id'],
                    'name' => $item['name'],
                    'quantity'=>$item['quantity']
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
            'message'=>$e->getMessage()
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
//                        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
//                        \Image::make($image)->save(public_path('images/').$name);
                        $name = $image->getClientOriginalName();
                        $update['img'] = $_SERVER['HTTP_HOST']. '/images/'.$name;
                    }
                    $update['slug'] = Str::slug($update['name'],'-');
                    $data['listimg'] = explode(",", $data['listimg']);
//                        if(count($update['listimg'])>count($data['listimg'])){
//                            for($i=count($data['listimg']);$i<count($update['listimg']); $i++){
//                                $image = $update['listimg'][$i];
//                                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
//                                \Image::make($image)->save(public_path('images/').$name);
//                                $data['listimg'][$i] = $_SERVER['HTTP_HOST'].'/images/'.$name;
//                            }
                            foreach ($update['listimg'] as $key => $list){
                                if($key > count($data['listimg'])){
                                $image = $update['listimg'][$key];
//                                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
//                                \Image::make($image)->save(public_path('images/').$name);
                                $name = $image->getClientOriginalName();
                                $data['listimg'][$key] = $_SERVER['HTTP_HOST']. '/images/'.$name;
                                }
                                else{

                                }
                        }
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
                'message'=>$e->getMessage()
            ]);
        }

    }
//    public function update_product(ProductUpdate $request, $product)
//    {
//        try {
//            $data = Product::find($product);
//            if($data != null){
//                $update =  $request->all();
//                if($update->hasFile('img')) {
//                    if(file_exists(public_path().$data['img'])){
//                        unlink(public_path().$data['img']);
//                    }
//                    $image = $request['img'];
////                        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
////                        \Image::make($image)->save(public_path('images/').$name);
//                    $name = $image->getClientOriginalName();
//                    $update['img'] = '/images/'.$name;
//                }
//                $update['slug'] = Str::slug($update['name'],'-');
//                $data['listimg'] = explode(",", $data['listimg']);
////                        if(count($update['listimg'])>count($data['listimg'])){
////                            for($i=count($data['listimg']);$i<count($update['listimg']); $i++){
////                                $image = $update['listimg'][$i];
////                                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
////                                \Image::make($image)->save(public_path('images/').$name);
////                                $data['listimg'][$i] = '/images/'.$name;
////                            }
//                foreach ($update['listimg'] as $key => $list){
//                    if($key > count($data['listimg'])){
//                        $image = $list;
////                                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
////                                \Image::make($image)->save(public_path('images/').$name);
//                        $name = $image->getClientOriginalName();
//                        $data['listimg'][$key] = '/images/'.$name;
//                    }
//                    else{
//
//                    }
//                }
//                $data->update($update);
//                return response()->json([
//                    'success' => true,
//                    'message'=>  'update thành công',
//                    'data'=>$data
//                ]);
//            }
//            else{
//                return response()->json([
//                    'success' => false,
//                    'message'=>'Dữ liệu không tồn tại'
//                ]);
//            }
//
//        }catch (\Exception $e){
//            return response()->json([
//                'success' => false,
//                'message'=>'update du lieu that bai',
//                'errors'=>$e->getMessage()
//            ]);
//        }
//
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        try {
                $data = Product::find($product);
                if($data != null){
                    if(file_exists(public_path().$data['img'])){
                        unlink(public_path().$data['img']);
                    }
                    $data['listimg'] = explode(",", $data['listimg']);
                    foreach ($data['listimg'] as $list){
                        if(file_exists(public_path().$list)){
                            unlink(public_path().$list);
                        }
                    }
                    Attribute::where('product_id',$data['id'])->delete();
                    CmtRating::with('product_id',$data['id'])->delete();
                    $data->delete();
                    return response()->json([
                        'success' => true,
                        'message'=>  'xóa thành công',
                        'data'=>$data['listimg']
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
