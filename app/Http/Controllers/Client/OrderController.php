<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;
    public function __construct(Order $order){
        $this->order = $order;
    }
    public function index(){
        $orders = $this->order->getOrderByUser(auth()->user()->id);
        return view('client.order.index', compact('orders'));
    }
    public function cancel($id){
        $orders = $this->order->findOrFail($id);
        $orders->update(['status'=>'cancel' ]) ;
        toastr()->success('Order cancel successfully');
        return to_route('client.order.index');

    }
}
