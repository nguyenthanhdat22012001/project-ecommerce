<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Store;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOrdersUserId($user_id)
    {         
        try {
            $orders = Order::with('payment')
            ->where('user_id','=',$user_id)
            ->get();

            if($orders != null){
                return response()->json([
                    'success' => true,
                    'message'=>  'Lấy đơn hàng thành công',
                    'data'=>$orders
                    ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'Đơn hàng này không tồn tại'
                ]);
            }
      
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
    public function getOrdersByStoreId($store_id)
    {         
        try {
            $orders = Order::with('order')
            ->where('store_id','=',$store_id)
            ->get();

            if($orders != null){
                return response()->json([
                    'success' => true,
                    'message'=>  'Lấy đơn hàng thành công',
                    'data'=>$orders
                    ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'Đơn hàng này không tồn tại'
                ]);
            }
      
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
    public function getOrdersAdmin()
    {         
        try {
            $orders = Order::where('store_id','=',null)->get();

            if($orders != null){
                return response()->json([
                    'success' => true,
                    'message'=>  'Lấy đơn hàng thành công',
                    'data'=>$orders
                    ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'Đơn hàng này không tồn tại'
                ]);
            }
      
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
    public function getOrderById($id)
    {         
        try {
            $order = Order::with('sub_order','payment','order')
            ->where('id','=',$id)
            ->first();

            $sub_orders = Order::where('parent_id',$order->id)->pluck('id')->toArray();
            array_push($sub_orders, $order->id);
            $order['product'] = Order_detail::whereIn('order_id',$sub_orders)->get();

            $store_ids = Order::where('parent_id',$order->id)->pluck('store_id')->toArray();
            $order['stores'] = Store::whereIn('id',$store_ids)->get();

            if($order != null){
                return response()->json([
                    'success' => true,
                    'message'=>  'Lấy đơn hàng thành công',
                    'data'=>$order
                    ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'Đơn hàng này không tồn tại'
                ]);
            }
      
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
    public function postOrder(Request $request)
    {
        // return $request['cart']['coupon']['sku'];
        try {
            if(!empty($request['cart']['coupon'])){
                $order =  Order::create([
                    "coupon_sku" => $request['cart']['coupon']['sku'],
                    "coupon_price" => $request['cart']['coupon']['price'],
                    "payment_id" => $request['payment_id'],
                    "user_id" => $request['user_id'],
                    "name" => $request['name'],
                    "address" => $request['address'],
                    "phone" => $request['phone'],
                    "note" =>  $request['note'],
                    "shippingprice" => $request['cart']['feeShip'],
                    "totalprice" => $request['cart']['totalPrice'],
                    "totalQuantity" => $request['cart']['totalQuantity'],
                    "created_at" => Carbon::now(),
                    "updated_at" =>Carbon::now(),
               ]);
            }else{
                $order =  Order::create([
                    "payment_id" => $request['payment_id'],
                    "user_id" => $request['user_id'],
                    "name" => $request['name'],
                    "address" => $request['address'],
                    "phone" => $request['phone'],
                    "note" =>  $request['note'],
                    "shippingprice" => $request['cart']['feeShip'],
                    "totalprice" => $request['cart']['totalPrice'],
                    "totalQuantity" => $request['cart']['totalQuantity'],
                    "created_at" => Carbon::now(),
                    "updated_at" =>Carbon::now(),
               ]);
            }
     

           foreach ( $request['cart']['stores'] as $stor) {
            if(!empty($stor['coupon'])){
                $sub_order =  Order::create([
                    "coupon_sku" =>  $stor['coupon']['sku'],
                    "coupon_price" =>  $stor['coupon']['price'],
                    "parent_id" => $order['id'],
                    "store_id" =>  $stor['store']['id'],
                    "totalprice" =>  $stor['totalPrice'],
                    "totalQuantity" =>  $stor['totalQuantity'],
                    "created_at" => Carbon::now(),
                    "updated_at" =>Carbon::now(),
            ]);
            }else{
                $sub_order =  Order::create([
                    "parent_id" => $order['id'],
                    "store_id" =>  $stor['store']['id'],
                    "totalprice" =>  $stor['totalPrice'],
                    "totalQuantity" =>  $stor['totalQuantity'],
                    "created_at" => Carbon::now(),
                    "updated_at" =>Carbon::now(),
            ]);
            }
        
            
            foreach ($stor['products'] as $prd) {
                foreach ($prd['attributes'] as $attribute) {
                    Order_detail::create([
                        "order_id" => $sub_order['id'],
                        "product_id" =>  $prd['product']['id'],
                        "product_name" => $prd['product']['name'],
                        "product_img" =>  $prd['product']['img'],
                        "product_price" =>  $prd['product']['price'],
                        "product_slug" =>  $prd['product']['slug'],
                        "attribute_name" =>  $attribute['name'],
                        "amount" =>  $attribute['quantity'],
                        "created_at" => Carbon::now(),
                        "updated_at" =>Carbon::now(),
                    ]);
                };
            };

           };

           if(!empty($order)){
            return response()->json([
                'success' => true,
                'message'=>  'Đặt hàng thành công',
                "data" => $order ,
            ]);
           }else{
            return response()->json([
                'success' => false,
                'message'=>"không thể thanh toán được",
            ]);
           }
         
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
    public function updateStatusOrder(Request $request,$id)
    {         
        try {
            $request['updated_at'] =  Carbon::now();
            $data = Order::with('order')->find($id);
            // $data->update($request->all())

            if($request['status'] == 0){
                if(!empty($data['order'])){
                    $ids = Order::where('parent_id',$data['order']['id'])->pluck('id')->toArray();
                    array_push($ids,$data['order']['id']);
                }else{
                    $ids = Order::where('parent_id',$id)->pluck('id')->toArray();
                    array_push($ids,$id);
                }
                // Order::find($data['order']['id'])->update($request->all());
                Order::whereIn('id', $ids)->update($request->all());
            }else{
                $data->update($request->all());

                if(!empty($data['order'])){
                    $status = Order::where('parent_id',$data['order']['id'])->orderBy('status')->pluck('status')->toArray();
                    Order::find($data['order']['id'])->update(["status" =>$status[0]]);
                }else{
                    $ids = Order::where('parent_id',$id)->pluck('id')->toArray();
                    Order::whereIn('id', $ids)->update($request->all());
                }
            }
         
                return response()->json([
                    'success' => true,
                    'message'=>  'cập nhật đơn hàng thành công',
                    'data'=>$data
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
    public function getOrderByUserAndId(Request $request)
    {         
        try {
            $order = Order::with('sub_order','payment')
            ->where('user_id','=',$request['user_id'])
            ->where('id','=',$request['id'])
            ->first();

         $sub_orders = Order::where('parent_id',$order->id)->pluck('id')->toArray();
         $order['product'] = Order_detail::whereIn('order_id',$sub_orders)->get();

            if($order != null){
                return response()->json([
                    'success' => true,
                    'message'=>  'Lấy đơn hàng thành công',
                    'data'=>$order
                    ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message'=>'Đơn hàng này không tồn tại'
                ]);
            }
      
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage(),
            ],500);
        }
    }
}
