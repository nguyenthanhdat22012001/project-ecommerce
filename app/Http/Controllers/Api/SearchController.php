<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $data = $request->all();
    try {
       $query = Product::query();
       $s = $data['search'];
           $query->whereRaw("name LIKE '%". $s ."%'" )->orWhereRaw("description LIKE '%". $s ."%'" );
       return response()->json([
        'success' => true,
        'message'=>  'Tìm thành công',
        'data'=>$query->get()
    ]);
    }catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message'=> $e->getMessage()
        ]);
    }
    }

   
}
