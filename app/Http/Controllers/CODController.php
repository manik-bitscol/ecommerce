<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\State;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CODController extends Controller
{
    public function index(Request $request)
    {

        $state = State::with('district')->findoRFail($request->state_id);
        try {
            if (Session::has('coupon'))
            {
                $amount   = Session::get('coupon')['totalAmount'] + intval($request->shipping_cost);
                $discount = Session::get('coupon')['discount'];
            }
            else
            {
                $amount   = intval(round(Cart::total())) + intval($request->shipping_cost);
                $discount = null;
            }
            $invoice = "EPEC-" . mt_rand(10000000, 99999999);
            $orderId = Order::insertGetId([
                'user_id'         => Auth::id(),
                'division_id'     => $request->division_id,
                'district_id'     => $request->district_id,
                'state_id'        => $request->state_id,
                'address1'        => $request->address1,
                'address2'        => $request->address2,
                'name'            => $request->name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'post_code'       => $request->post_code,
                'payment_method'  => 'COD',
                'transaction_id'  => uniqid(),
                'currency'        => "BDT",
                'amount'          => $amount,
                'shipping_cost'   => $request->shipping_cost,
                'coupon_discount' => $discount,
                'order_number'    => uniqid(),
                'invoice_no'      => $invoice,
                'order_date'      => Carbon::now()->format('d F Y'),
                'order_month'     => Carbon::now()->format('F'),
                'order_year'      => Carbon::now()->format('Y'),
                'notes'           => $request->notes,
                'created_at'      => Carbon::now(),
            ]);

            $carts = Cart::content();

            foreach ($carts as $cart)
            {
                OrderItem::create([
                    'order_id'     => $orderId,
                    'product_id'   => $cart->id,
                    'product_name' => $cart->name,
                    'color'        => $cart->options->color,
                    'size'         => $cart->options->size,
                    'qty'          => $cart->qty,
                    'price'        => $cart->price,
                ]);
            }
            $mailInfo = [
                'order_id'   => $orderId,
                'invoice_no' => $invoice,
                'price'      => $amount,
            ];
            Mail::to($request->email)->send(new OrderMail($mailInfo));
            if (Session::has('coupon'))
            {
                Session::forget('coupon');
            }
            Cart::destroy();
            return redirect()->route('home')->withSuccess('Your Order has reveived');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }

    }
}