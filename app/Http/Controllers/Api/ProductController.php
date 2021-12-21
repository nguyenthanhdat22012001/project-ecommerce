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
            $data = Product::withCount('order')->orderBy('order_count', 'desc')->get();
            foreach (  $data  as $item) {
                $sumStars = CmtRating::where('product_id',$item->id)->avg('point');
                 $item->totalRating = floor($sumStars);
                 $totalComment = count(CmtRating::where('product_id',$item->id)->get());
                 $item->totalComment = $totalComment;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStore $request)
    {
        $data = $request->all();
        try {
     if(isset($data['attributes']) && count($data['attributes']) > 0 ){
        $data['slug'] = Str::slug($data['name'],'-');
        $listimages=array();
        if(isset($data['img'])) {
            $image = $data['img'];
           $name = rand(10,100).time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           \Image::make($image)->save(public_path('images/').$name);
            // $name = $image->getClientOriginalName();
            $data['img'] ='http://'.$_SERVER['HTTP_HOST']. '/images/'.$name;
        }
        else{
            return response()->json([
                'success' => false,
                'message'=>  'Chưa có ảnh đại diện'
            ]);
        }
            if(isset($data['listimg']) && count($data['listimg']) > 0) {
                foreach ($data['listimg'] as $list){
                    $image = $list;
                   $name = rand(10,100).time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                   \Image::make($image)->save(public_path('images/').$name);
                    // $name = $image->getClientOriginalName();
                    $listimages[] = 'http://'.$_SERVER['HTTP_HOST']. '/images/'.$name;
                }
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>  'Chưa có danh sách hình ảnh'
                ]);
            }
        $listimages =  implode(",",$listimages);
        $data['listimg'] = $listimages;
        $product = Product::create($data);

        foreach ($data['attributes'] as $item){
            Attribute::create([
                'product_id'=>$product['id'],
                'name' => $item['name'],
                'quantity'=>$item['quantity']
            ]);
        }

        return response()->json([
            'success' => true,
            'message'=>  'Thêm thành công',
            'data'=>$data
        ]);
     }else{
        return response()->json([
            'success' => false,
            'message'=>  'Nhập tối thiểu 1 thuộc tính'
        ]);
     }
    
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
            $data->attributes;
            $data->brand;
            $data->cate;
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
                    'message'=>'sản phẩm không tồn tại',
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
        $data = Product::find($product);
        $update =  $request->all();
        try {
              if(isset($data['attributes']) && count($data['attributes']) > 0 ){

                if($data != null){
                    $update['slug'] = Str::slug($update['name'],'-');
                    if(isset($update['img'])) {
                        if($update['img'] != $data['img']){
                            if(file_exists(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $data['img'] ))){
                                unlink(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $data['img'] ));
                            }
                            $image = $request['img'];
                            $name = rand(10,1000).time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                            \Image::make($image)->save(public_path('images/').$name);
    //                        $name = $image->getClientOriginalName();
                            $update['img'] ='http://'. $_SERVER['HTTP_HOST']. '/images/'.$name;
                        }
                  
                    }else{
                        return response()->json([
                            'success' => false,
                            'message'=>'Chưa có hình đại diện',
                        ]);
                    }

                    if(isset($update['listimg']) && count($update['listimg']) > 0){
                        $data['listimg'] = explode(",", $data['listimg']);
                        $newImages = array();
                        foreach ($data['listimg'] as $image){
                            if (in_array($image, $update['listimg'])) {
                                array_push($newImages, $image);
                            }
                        }

                        foreach ($data['listimg'] as $image){
                            if (!in_array($image, $newImages)) {
                                if(file_exists(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $image ))){
                                    unlink(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $image ));
                                }
                            }
                        }

                        foreach ($update['listimg'] as $img){
                            if (!in_array($img, $newImages)) {
                                $image = $img;
                                $name = rand(10,1000).time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                                \Image::make($image)->save(public_path('images/').$name);
                                 // $name = $image->getClientOriginalName();
                                 $linkImage = 'http://'.$_SERVER['HTTP_HOST']. '/images/'.$name;
                                 array_push($newImages, $linkImage);
                            }
                        }
                        $update['listimg'] = $newImages;
                    }else{
                        return response()->json([
                            'success' => false,
                            'message'=>'Chưa có danh sách hình ảnh',
                        ]);
                    }

                    $update['listimg']= implode(",", $update['listimg']);
                    $data->update($update);

                    Attribute::where('product_id',$data['id'])->delete();
          
                        foreach ($update['attributes'] as $item){
                            Attribute::create([
                                'product_id'=>$data['id'],
                                'name' => $item['name'],
                                'quantity'=>$item['quantity']
                            ]);
                        }
                    
                   
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

              }else{
                    return response()->json([
                        'success' => false,
                        'message'=>  'Nhập tối thiểu 1 thuộc tính'
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
    public function destroy($product)
    {
        try {
                $data = Product::find($product);
                if($data != null){
                    if(file_exists(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $data['img'] ))){
                        unlink(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $data['img'] ));
                    }
                    $data['listimg'] = explode(",", $data['listimg']);
                    foreach ($data['listimg'] as $list){
                        if(file_exists(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $list ))){
                            unlink(public_path().str_replace( 'http://'.$_SERVER['HTTP_HOST'], '', $list ));
                        }
                    }
                    Attribute::where('product_id',$data['id'])->delete();
                    CmtRating::with('product_id',$data['id'])->delete();
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
            'message'=>$e->getMessage()
        ]);
    }

    }
}
