<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Store;
use App\Models\CollectionStore;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DoashboardController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function statisticsGeneralOfStore($store_id)
    {         
        try {
            $numberFollow = count(CollectionStore::where('store_id','=',$store_id)->get());

            $numberOrdersToday = count(Order::where('store_id','=',$store_id)
            ->whereDate('created_at','=',Carbon::now()->toDateString())
            ->where('status','!=',0)
            ->get());

            $RevenueToday = Order::where('store_id','=',$store_id)
            ->whereDate('created_at','=',Carbon::now()->toDateString())
            ->where('status','=',4)
            ->sum('totalprice');

            $storeTop = Order::selectRaw('sum(totalprice) as sumTotalprice, store_id')
            ->whereDate('created_at','like','%'.Carbon::now()->format('Y-m').'%')
            ->where('status','=',4)
            ->where('store_id','!=',null)
            ->groupBy('store_id')
            ->orderBy('sumTotalprice','desc')
            ->get();

            $rankStore = 0;
            if(!empty($storeTop)){
                foreach ($storeTop as $index => $item) {
                    if($item['store_id'] == $store_id){
                        $rankStore = $index + 1 ;
                    };
                };
            }

            return response()->json([
                'success' => true,
                'message'=>  'Lấy đơn hàng thành công',
                'data'=>[
                    "numberFollow" => $numberFollow,
                    "numberOrdersToday" => $numberOrdersToday,
                    "revenueToday" => $RevenueToday,
                    "rankStore" =>  $rankStore,
                ],
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
    public function statisticsRevenueMonthOfStore($store_id)
    {         
        try {
            $revenueMonthOfStore =  array();
            for ($i=1; $i <= 12; $i++) { 
                $obj = [
                    "month_name" => "Tháng ".$i,
                    "date" => Carbon::create(Carbon::now()->year,$i)->format('Y-m'),
                    "revenue" => 0,  
                ];
                array_push($revenueMonthOfStore, $obj);
            }

            foreach ($revenueMonthOfStore as $index => $item) {
                $totalRevenue = Order::where('store_id','=',$store_id)
                ->whereDate('created_at','like','%'.$item['date'].'%')
                ->where('status','=',4)
                ->sum('totalprice');

                $revenueMonthOfStore[$index]['revenue'] =  $totalRevenue;
            }

            return response()->json([
                'success' => true,
                'message'=>  'Lấy đơn hàng thành công',
                'data'=> $revenueMonthOfStore
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
    public function statisticsProductHotTrendByMonth($store_id)
    {         
        try {
            $orderIds = Order::where('store_id','=',$store_id)
            ->where('status','=',4)->pluck('id')->toArray();
            $products = Product::select('id','name')
            ->where('store_id',$store_id)->get();
            $newData =  array();

            $revenueProductTrendMonthOfStore =  array();
            for ($i=1; $i <= 12; $i++) { 
                $obj = [
                    "month_name" => "Tháng ".$i,
                    "date" => Carbon::create(Carbon::now()->year,$i)->format('Y-m'),
                ];
                array_push($revenueProductTrendMonthOfStore, $obj);
            }

            foreach ($products as $prd) {
                $amounts_prd = array();
                foreach ($revenueProductTrendMonthOfStore as $index => $item) {
                    $totalBuy = Order_detail::whereDate('created_at','like','%'.$item['date'].'%')
                    ->whereIn('order_id',$orderIds)
                    ->where('product_id',$prd['id'])
                    ->groupBy('product_id')
                    ->sum('amount');

                    array_push($amounts_prd,  (int)$totalBuy );
                };

                array_push($newData,[
                    "label" => $prd['name'],
                    "data" => $amounts_prd,
                ]);
            };


            return response()->json([
                'success' => true,
                'message'=>  'Lấy đơn hàng thành công',
                'data'=> $newData 
            ]);
      
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage(),
            ],500);
        }
    }

}
