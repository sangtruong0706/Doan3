<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCanCheckoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('cart')) {
            // Nếu không có giỏ hàng, bạn có thể chuyển hướng hoặc xử lý theo ý muốn
            // return redirect()->route('home')->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.');
            abort('404', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.');
        }
        $cart = session()->get('cart');
        if (empty($cart['product_id'])) {
            // Nếu giỏ hàng không có sản phẩm, bạn cũng có thể chuyển hướng hoặc xử lý theo ý muốn
            // return redirect()->route('home')->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.');
            abort('404', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.');
        }

        return $next($request);
    }
}
