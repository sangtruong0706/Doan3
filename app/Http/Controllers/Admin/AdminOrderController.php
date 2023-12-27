<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminOrderController extends Controller
{
    protected $order;
    public function __construct(Order $order){
        $this->order = $order;
    }
    public function index(){
        // $orders = $this->order->getOrderByUser(auth()->user()->id)->paginate(10);
        $orders = $this->order->latest('id')->paginate(10);
        return view('admin.order.index', compact('orders'));
    }
    public function updateStatus(Request $request, $id){
        $orders = $this->order->findOrFail($id);
        if (!$orders) {
            return response()->json(['error' => 'Đơn hàng không tồn tại'], 404);
        }
        // $orders->update(['status'=>$request->status ]) ;
        $orders->status = $request->input('status');
        $orders->save();
        return response()->json(['message' => 'Cập nhật trạng thái thành công']);
    }
    public function delete($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Đơn hàng không tồn tại'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Đã xóa đơn hàng thành công']);
    }
}
