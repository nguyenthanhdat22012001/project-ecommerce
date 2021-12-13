<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\Product;
use App\Models\Store;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
   protected $product;
   protected $totalPrice;
   protected $quantity;
   public function addToCart(Request $request){

        try {
            $product=Product::with('store:id,name,slug,img')
            ->select('id','name','store_id','slug','img','price','discount')
            ->where('id',$request->product_id)->first();

            if($product){

                $attribute=Attribute::select('id','product_id','name','quantity')
                ->where('id',$request->attribute_id)->first();
                if($attribute->quantity < $request->quantity){
                    return response()->json([
                        'success' => false,
                        'message'=> "Số lượng sản phẩm không đủ"
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message'=>  'Thêm giỏ hàng thành công',
                    'data'=>[
                        'store'=>$product->store,
                        'product'=>$product,
                        'attribute'=>$attribute,
                        'quantity' => $request->quantity
                    ]
                ]);

            }else{
                return response()->json([
                    'success' => false,
                    'message'=>"Sản phẩm này không tồn tại"
                ]);
            }


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage(),
            ]);
        }
   }
}
