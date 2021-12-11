<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
   protected $product;
   protected $totalPrice;
   protected $quantity;
   public function addToCart(Request $request){
        $product_id=$request->product_id;
//       $product_qty=$request->product_qty;
       $product_qty=1;
        $check=Product::where('id',$product_id)->first();
//        dd($product_id);
        if($check){
            return response()->json([
                'message' => 'Hello',
                'data'=>[
                    'store'=>$check->store,
                    'product'=>$check,
                    'attribute'=>'chua lam'
                ]
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found'
            ]);
        }
   }
}
