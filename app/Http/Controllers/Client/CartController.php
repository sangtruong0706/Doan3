<?php

namespace App\Http\Controllers\Client;

use auth;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Order\CreateOrderRequest;

// use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $coupon, $order;
    public function __construct(Coupon $coupon, Order $order)
    {
        $this->coupon = $coupon;
        $this->order = $order;
    }
    public function applyCoupon(Request $request)
    {
        $name = $request->input('coupon_code');
        $coupon_ = $this->coupon->firstWithExperyDate($name, auth()->user()->id);
        if ($coupon_) {
            toastr()->success('Apply coupon successfully');
            session()->put('coupon_id', $coupon_->id);
            session()->put('discount_amount_price', $coupon_->value);
            session()->put('coupon_code', $coupon_->name);
        } else {
            session()->forget('coupon_id', 'discount_amount_price', 'coupon_code');
            toastr()->error("Coupon does not exist or invalid");
        }
        return redirect()->back();
    }
    public function checkout()
    {
        $user = auth()->user();
        if(!$user){
            return to_route('login');
        }
        return view('client.home.checkout', compact('user'));
    }
    public function handleCheckout(CreateOrderRequest $request)
    {
        $dataCreate = $request->all();
        $dataCreate['user_id'] = auth()->user()->id;
        $dataCreate['order_id'] = random_int(0, 9999);
        $dataCreate['status'] = 'pending';
        $total = $request->total;
        if ($request->payment == 'money') {
            $result = $this->order->create($dataCreate);
            $couponId = session()->get('coupon_id');
            if ($couponId) {
                $coupon = $this->coupon->find($couponId);
                if ($coupon) {
                    $coupon->users()->attach(auth()->user()->id, ['value' => $coupon->value]);
                }
            }
            $cart = session()->get('cart');
            foreach ($cart as $item) {
                $productId = $item['product_id'];
                $selectedSize = $item['size'];
                $orderQuantity = $item['quantity'];
                //cap nhat so luong ban
                $product = Product::find($productId);
                $product->sold_quantity += $orderQuantity;
                $product->save();
                $productSize = ProductDetail::where('product_id', $productId)
                    ->where('size', $selectedSize)
                    ->first();

                if ($productSize && $productSize->quantity >= $orderQuantity) {
                    $productSize->quantity -= $orderQuantity;
                    $productSize->save();
                } else {
                    // Xử lý khi số lượng không đủ
                }
            }
            toastr()->success('Order successfully!');
            return to_route('thankyou');
        } elseif ($request->payment == 'vnpay') {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $vnp_TmnCode = "VHKWZDMW"; //Website ID in VNPAY System
            $vnp_HashSecret = "IJRCDIKQIAXXALPXPOOVVMZXADGZTPXO"; //Secret key
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://127.0.0.1:8000/thankyou";
            $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
            $startTime = date("YmdHis");
            $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
            $vnp_TxnRef = $dataCreate['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = "Thanh toán hóa đơn";
            $vnp_OrderType = "billpayment";
            $vnp_Amount = $total * 100;
            $vnp_Locale = "EN";
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,

            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00', 'message' => 'success', 'data' => $vnp_Url
            );
            if (isset($_POST['redirect'])) {
                $result = $this->order->create($dataCreate);
                $couponId = session()->get('coupon_id');
                if ($couponId) {
                    $coupon = $this->coupon->find($couponId);
                    if ($coupon) {
                        $coupon->users()->attach(auth()->user()->id, ['value' => $coupon->value]);
                    }
                }
                $cart = session()->get('cart');
                foreach ($cart as $item) {
                    $productId = $item['product_id'];
                    $selectedSize = $item['size'];
                    $orderQuantity = $item['quantity'];
                    $product = Product::find($productId);
                    $product->sold_quantity += $orderQuantity;
                    $product->save();
                    $productSize = ProductDetail::where('product_id', $productId)
                        ->where('size', $selectedSize)
                        ->first();

                    if ($productSize && $productSize->quantity >= $orderQuantity) {
                        $productSize->quantity -= $orderQuantity;
                        $productSize->save();
                    } else {
                        // Xử lý khi số lượng không đủ
                    }
                }
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
        }





        // foreach ($cartItems as $cartItem) {
        //     ProductOrder::create([
        //         'order_id' => $dataCreate['order_id'],
        //         'product_id' => $cartItem['product_id'],
        //         'product_size' => $cartItem['size'],
        //         'product_color' => null,
        //         'product_quantity' => $cartItem['quantity'],
        //         'product_price' => $cartItem['price'],
        //     ]);
        // }
        Session::forget('cart');
        // // session()->put('cart', []);
        Session::forget('coupon_id', 'discount_amount_price', 'coupon_code');
    }
    public function thankyou(Request $request)
    {
        // Lấy giá trị từ URL
        $vnp_TransactionStatus = $request->input('vnp_TransactionStatus');
        $vnp_TxnRef = $request->input('vnp_TxnRef');

        if ($vnp_TransactionStatus == '00') {
            // Trạng thái thanh toán hợp lệ, giữ nguyên đơn hàng trong cơ sở dữ liệu
            Session::forget('cart');
            // // session()->put('cart', []);
            Session::forget('coupon_id', 'discount_amount_price', 'coupon_code');
            return view('client.home.thankyou');
        } else if($vnp_TransactionStatus == '02') {
            // Trạng thái thanh toán không hợp lệ, xóa đơn hàng dựa trên $vnp_TxnRef
            $order = Order::where('order_id', $vnp_TxnRef)->first();
            if ($order) {
                $order->delete();
            }
            return view('client.home.cancel_checkout_vnpay');
        }else{
            // Trạng thái thanh toán hợp lệ, giữ nguyên đơn hàng trong cơ sở dữ liệu
            Session::forget('cart');
            // // session()->put('cart', []);
            Session::forget('coupon_id', 'discount_amount_price', 'coupon_code');
            return view('client.home.thankyou');
        }
        // ... và các giá trị khác

    }
}


// http://localhost/Doan2-git/Doan2/cart/thankYou?vnp_Amount=2300000000&vnp_BankCode=VNPAY&vnp_CardType=QRCODE&vnp_OrderInfo=Thanh+to%C3%A1n+%C4%91%C6%A1n+h%C3%A0ng&vnp_PayDate=20231218192857&vnp_ResponseCode=24&vnp_TmnCode=VHKWZDMW&vnp_TransactionNo=0&vnp_TransactionStatus=02&vnp_TxnRef=5132&vnp_SecureHash=0b246ebd4034fe670b60e4ab355aa2a93e3643adb9906bb414fa19b7085b567b768037aaad84eae0258b17a9640ed7545d40c35fdd4b3c6830070cb39f8baa76
// http://localhost/Doan2-git/Doan2/cart/thankYou?vnp_Amount=19900000&vnp_BankCode=NCB&vnp_BankTranNo=VNP14249372&vnp_CardType=ATM&vnp_OrderInfo=Thanh+to%C3%A1n+%C4%91%C6%A1n+h%C3%A0ng&vnp_PayDate=20231218193049&vnp_ResponseCode=00&vnp_TmnCode=VHKWZDMW&vnp_TransactionNo=14249372&vnp_TransactionStatus=00&vnp_TxnRef=2251&vnp_SecureHash=1471ae2094ab0a78a69312a43858aa099aa28654c288dde2c83e78ee18c7b8b96eb9e7cf1d43998e8ae8ae9f01e509a11aa24487ad15cbf9b95cc140f5810775
http://127.0.0.1:8000/thankyou?vnp_Amount=1000000&vnp_BankCode=NCB&vnp_BankTranNo=VNP14249377&vnp_CardType=ATM&vnp_OrderInfo=Thanh+to%C3%A1n+h%C3%B3a+%C4%91%C6%A1n&vnp_PayDate=20231218193505&vnp_ResponseCode=00&vnp_TmnCode=VHKWZDMW&vnp_TransactionNo=14249377&vnp_TransactionStatus=00&vnp_TxnRef=6335&vnp_SecureHash=3aaa683c23bbcaf72c7982d3217b054d0c5ba8faecc94651c77349b60d6bd52888eac77eb1ebc3c58762e8ac5856fcdd66f10f43499a38894fd1be8cede5f0c6
