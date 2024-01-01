<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Product;
use App\Models\Verifytoken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->latest('id')->paginate(8);
        $hotProducts = $this->product->where('sold_quantity', '>', 2)->latest('id')->get();
        return view('client.home.index', compact('products', 'hotProducts'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        return view('client.home.search_result', compact('products'));
    }
    public function showCart()
    {
        return view('client.home.cart');
    }
    public function addCart(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        $size = $request->size;
        $product = $this->product->findOrFail($id);
        // Lấy thông tin hình ảnh từ quan hệ images
        $productImages = $product->images;
        $cart = session()->get('cart', []);

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng hay chưa
        $productKey = $id . '_' . $size;
        if (!$size) {
            toastr()->error('You should choose a size');
            return redirect()->back();
        }
        if (isset($cart[$productKey])) {
            // Nếu đã có, tăng số lượng
            $cart[$productKey]['quantity'] += $quantity;
        } else {
            // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
            $cart[$productKey] = [
                'id' => $productKey,
                'product_id' => $id,
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'sale_price' => $product->sale,
                'discounted_price' => $product->sale ? $product->price -($product->sale*0.01*$product->price) : $product->price,
                'size' => $size,
                'image' =>  $productImages->count() > 0 ? asset('upload/' . $productImages->first()->url) : asset('upload/default.jpg'),
            ];
        }
        // dd($cart[$productKey]);
        session()->put('cart', $cart);

        toastr()->success('Add product to cart successfully!');

        return redirect()->route('show.cart');
    }
    public function updateCart(Request $request)
    {
        $productId = $request->productId;
        $action = $request->action;
        // Lấy giỏ hàng từ session, nếu không có thì tạo mới
        $cart = session()->get('cart', []);
        // Xử lý cập nhật giỏ hàng dựa trên action
        $subAllTotal =0;
        if ($productId && isset($cart[$productId])) {
            if ($action == 'plus') {
                $cart[$productId]['quantity']++;
            } elseif ($action == 'minus') {
                $cart[$productId]['quantity']--;
                $cart[$productId]['quantity'] = max($cart[$productId]['quantity'], 0);
            } elseif ($action == 'delete') {
                unset($cart[$productId]);
            }
        }
        session()->put('cart', $cart);

        foreach($cart as $item){
            $subAllTotal+= $item['price'] * $item['quantity'];
        }

        // Lưu giỏ hàng mới vào session
        $cartQuantity = count((array) session('cart'));
        // Tính toán total mới
        if ($action == 'plus'||$action=='minus'){
            $subTotal =  $cart[$productId]['price'] * $cart[$productId]['quantity'];
        }else{
            $subTotal =  0;
        }
        $total = $this->calculateTotal($cart);

        // Trả về dữ liệu mới cho giao diện người dùng
        $cartData = [
            'productId' => $productId,
            'quantity' => $cartQuantity, // Số lượng sản phẩm trong giỏ hàng
            'subTotal' => $subTotal,
            'subAllTotal' => $subAllTotal,
            'total' => $total, // Tổng tiền giỏ hàng
            'action' => $action
        ];
        return response()->json($cartData);
    }

    // Hàm tính tổng tiền trong giỏ hàng
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            if (is_numeric($item['price']) && is_numeric($item['quantity'])) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }
    public function verifyAccount(){
        return view('client.home.otp_verify_account');
    }
    public function userActivation(Request $request){
        $get_token = $request->token;
        $get_token = Verifytoken::where('token', $get_token)->first();
        if($get_token){
            $get_token->is_active = 1;
            $get_token->save();
            $user = User::where('email', $get_token->email)->first();
            $user->is_active = 1;
            $user->save();
            $getting_token = Verifytoken::where('token', $get_token->token)->first();
            $getting_token->delete();
            toastr()->success('Your token has been verified');
            return redirect()->route('login')->with('activated', 'You have been activated successfully');


        }else{
            toastr()->error('Your OTP is invalid please check your mail settings');
            return redirect('/verifyaccount')->with('incorrect', 'Your OTP is invalid please check your mail settings');
        }
    }
    public function contact(){
        return view('client.home.contact');
    }
}
