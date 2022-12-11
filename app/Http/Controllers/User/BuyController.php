<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class BuyController extends Controller
{
    public function index(Request $request)
    {

        $color = $request->color;
        $size  = $request->size;
        $qty   = $request->qty;
        $order = [
            'product_id' => $request->product_id,
            'color'      => $color,
            'size'       => $size,
            'qty'        => $qty,
        ];
        $product = Product::findOrFail($request->product_id);
        $brands  = Brand::all();
        Session::put('order', $order);
        return view('user.buy.buy', compact('product', 'color', 'size', 'qty', 'brands'));
    }
    //Apply Coupon
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;
        $coupon     = Coupon::where('coupon_code', $couponCode)->first();

        if ($coupon)
        {
            if ($coupon->validity >= Carbon::now()->format('Y-m-d'))
            {
                $productId      = Session::get('order')['product_id'];
                $product        = Product::findOrFail($productId);
                $amount         = $product->discount_price;
                $discount       = $coupon->discount;
                $discountAmount = ($amount * $discount) / 100;
                $totalAmount    = $amount - $discountAmount;
                Session::put('coupon', [
                    'couponCode'     => $couponCode,
                    'couponDiscount' => $coupon->discount,
                    'discount'       => $discountAmount,
                    'subtotal'       => $amount,
                    'totalAmount'    => $totalAmount,
                ]);
                return response()->json(['success' => "{$couponCode} Applied Successfully"]);
            }
            else
            {
                return response()->json(['error' => 'Your Coupon is Expired']);
            }
        }
        else
        {
            return response()->json(['error' => 'Your Coupon is Invalid']);
        }
    }
    //Get Coupon Discount
    public function couponDiscount()
    {
        if (Session::has('coupon'))
        {
            $productId = Session::get('order')['product_id'];
            $product   = Product::findOrFail($productId);
            $subtotal  = $product->discount_price;
            $coupon    = session()->get('coupon')['couponCode'];
            $discount  = session()->get('coupon')['discount'];
            $total     = session()->get('coupon')['totalAmount'];
            return response()->json([
                'subtotal'    => $subtotal,
                'coupon'      => $coupon,
                'discount'    => $discount,
                'totalAmount' => $total,
            ]);
        }
        else
        {
            $productId = Session::get('order')['product_id'];
            $product   = Product::findOrFail($productId);
            $total     = $product->discount_price;
            return response()->json([
                'total' => $total,
            ]);
        }
    }
    //Remove Coupon
    public function removeCoupon()
    {

        Session::forget('coupon');
        return response()->json(['success' => 'Coupon successfully Removed']);

    }

    // Increase Qty
    public function increaseQty()
    {
        if (Session::has('order'))
        {
            $product_id = Session::get('order')['product_id'];
            $color      = Session::get('order')['color'];
            $size       = Session::get('order')['size'];
            $qty        = Session::get('order')['qty'];

            Session::remove('order');
            $updateQty = intval($qty) + 1;
            $order     = [
                'product_id' => $product_id,
                'color'      => $color,
                'size'       => $size,
                'qty'        => $updateQty,
            ];
            Session::put('order', $order);
            return response()->json([
                'qty' => Session::get('order')['qty'],
            ]);
        }
    }
    // Decrease Qty
    public function decreaseQty()
    {
        if (Session::has('order'))
        {
            $product_id = Session::get('order')['product_id'];
            $color      = Session::get('order')['color'];
            $size       = Session::get('order')['size'];
            $qty        = Session::get('order')['qty'];

            Session::remove('order');
            $updateQty = intval($qty) - 1;
            $order     = [
                'product_id' => $product_id,
                'color'      => $color,
                'size'       => $size,
                'qty'        => $updateQty,
            ];
            Session::put('order', $order);
            return response()->json([
                'qty' => Session::get('order')['qty'],
            ]);
        }
    }

}