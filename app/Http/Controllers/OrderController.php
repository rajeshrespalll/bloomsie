<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    //
    function index(){
        $user = Auth::user();
        $data_order = Order::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['product:id,product_name,product_description,product_price'])->get();
        
        return view('order.index', ['data_order'=>$data_order]);
    }
}
