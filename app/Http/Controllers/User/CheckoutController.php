<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\ShippingCost;
use App\Models\State;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::total() > 0)
        {
            if (Session::has('coupon'))
            {

                $cartProducts = Cart::content();
                $subtotal     = Cart::total();
                $total        = Session::get('coupon')['totalAmount'];
                $costs        = ShippingCost::latest()->get();
                return view('user.checkout', compact('cartProducts', 'subtotal', 'total', 'costs'));
            }
            else
            {

                $cartProducts = Cart::content();
                $total        = Cart::total();
                $costs        = ShippingCost::latest()->get();
                return view('user.checkout', compact('cartProducts', 'total', 'costs'));
            }
        }
        else
        {
            return redirect()->to('/')->withError('Please Add At least One Product to your Cart');
        }

    }
    public function getDivision()
    {
        $divisions = Division::orderBy('name', 'ASC')->get();
        return response()->json(['divisions' => $divisions]);
    }
    public function getDistrict($id)
    {

        $districts = District::where('division_id', $id)->orderBy('name', 'ASC')->get();
        return response()->json(['districts' => $districts]);
    }
    public function getState($id)
    {

        $states = State::where('district_id', $id)->orderBy('name', 'ASC')->get();
        return response()->json(['states' => $states]);
    }
    //
    public function storeShippingInfo(Request $request)
    {

        $shippingInfo                   = [];
        $shippingInfo['name']           = $request->name;
        $shippingInfo['email']          = $request->email;
        $shippingInfo['phone']          = $request->phone;
        $shippingInfo['division_id']    = $request->division_id;
        $shippingInfo['district_id']    = $request->district_id;
        $shippingInfo['state_id']       = $request->state_id;
        $shippingInfo['address1']       = $request->address1;
        $shippingInfo['address2']       = $request->address2;
        $shippingInfo['post_code']      = $request->post_code;
        $shippingInfo['notes']          = $request->notes;
        $shippingInfo['payment_method'] = $request->payment_method;
        $shippingInfo['shipping_cost']  = $request->shipping_cost;

        $cartProducts    = Cart::content();
        $cartQty         = Cart::count();
        $cartTotalAmount = Cart::total();

        if ($request->payment_method === 'stripe')
        {
            if (Session::has('coupon'))
            {
                $total       = Session::get('coupon')['totalAmount'];
                $totalAmount = intval($shippingInfo['shipping_cost']) + intval($total);
                $cartTotal   = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.stripe', compact('shippingInfo', 'cartTotal', 'totalAmount'));
            }
            else
            {
                $cartTotal = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.stripe', compact('shippingInfo', 'cartTotal'));
            }

        }
        elseif ($request->payment_method === 'paypal')
        {
            if (Session::has('coupon'))
            {
                $total       = Session::get('coupon')['totalAmount'];
                $totalAmount = intval($shippingInfo['shipping_cost']) + intval($total);
                $cartTotal   = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.stripe', compact('shippingInfo', 'cartTotal', 'totalAmount'));
            }
            else
            {
                $cartTotal = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.stripe', compact('shippingInfo', 'cartTotal'));
            }

        }
        elseif ($request->payment_method === 'sslcommerz_hosted')
        {
            if (Session::has('coupon'))
            {
                $total       = Session::get('coupon')['totalAmount'];
                $totalAmount = intval($shippingInfo['shipping_cost']) + intval($total);
                $cartTotal   = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.sslcommerz.hosted-checkout', compact('shippingInfo', 'cartProducts', 'cartQty', 'cartTotal', 'totalAmount'));
            }
            else
            {
                $cartTotal = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.sslcommerz.hosted-checkout', compact('shippingInfo', 'cartProducts', 'cartQty', 'cartTotal'));
            }
        }
        elseif ($request->payment_method === 'sslcommerz_easy')
        {
            if (Session::has('coupon'))
            {
                $total       = Session::get('coupon')['totalAmount'];
                $totalAmount = intval($shippingInfo['shipping_cost']) + intval($total);
                $cartTotal   = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.sslcommerz.eassy-checkout', compact('shippingInfo', 'cartProducts', 'cartQty', 'cartTotal', 'totalAmount'));
            }
            else
            {
                $cartTotal = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.sslcommerz.eassy-checkout', compact('shippingInfo', 'cartProducts', 'cartQty', 'cartTotal'));
            }
        }
        elseif ($request->payment_method === 'amaarpay')
        {
            if (Session::has('coupon'))
            {
                $total       = Session::get('coupon')['totalAmount'];
                $totalAmount = intval($shippingInfo['shipping_cost']) + intval($total);
                $cartTotal   = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.amaarpay.index', compact('shippingInfo', 'cartProducts', 'cartQty', 'cartTotal', 'totalAmount'));
            }
            else
            {
                $cartTotal = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.amaarpay.index', compact('shippingInfo', 'cartProducts', 'cartQty', 'cartTotal'));
            }

        }
        elseif ($request->payment_method === 'cod')
        {
            if (Session::has('coupon'))
            {
                $total       = Session::get('coupon')['totalAmount'];
                $totalAmount = intval($shippingInfo['shipping_cost']) + intval($total);
                $cartTotal   = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);

                return view('user.payment.cod.index', compact('shippingInfo', 'cartProducts', 'cartQty', 'cartTotal', 'totalAmount'));
            }
            else
            {
                $cartTotal = intval($shippingInfo['shipping_cost']) + intval($cartTotalAmount);
                return view('user.payment.cod.index', compact('shippingInfo', 'cartProducts', 'cartQty', 'cartTotal'));
            }

        }
        else
        {
            return redirect()->back()->withError('Please Select A Payment Method');
        }
    }

}