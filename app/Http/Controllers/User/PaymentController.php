<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\State;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{

    //Stripe payment

    public function stripe(Request $request)
    {
        if (Session::has('coupon'))
        {
            $totalAmount = Session::get('coupon')['totalAmount'];
            $amount      = round(intval($totalAmount) / 85);
            $discount    = Session::get('coupon')['discount'];
        }
        else
        {
            $amount   = round(Cart::total());
            $discount = null;
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = \Stripe\Charge::create([
            "amount"      => $amount * 100,
            "currency"    => "usd",
            "source"      => $request->stripeToken,
            "description" => "This payment from Manik Mia Account",
            "metadata"    => ["order_id" => uniqid()],
        ]);
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
            'payment_type'    => $charge->payment_method,
            'payment_method'  => 'Stripe',
            'transaction_id'  => $charge->balance_transaction,
            'currency'        => $charge->currency,
            'amount'          => $amount,
            'shipping_cost'   => $request->shipping_cost,
            'coupon_discount' => $discount,
            'shipping_cost'   => $request->shipping_cost,
            'coupon_discount' => $discount,
            'order_number'    => $charge->metadata->order_id,
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
        return redirect()->route('user.dashboard')->withSuccess('Your Order Successfully Placed. Please Wait For Product');
    }

    //Paypal Payment
    public function paypal(Request $request)
    {

    }

    //SSLCommerz Payment Gateway

    //SSLCommerz Hosted Checkout
    public function sslcommerzHosted(Request $request)
    {

        $state = State::with('district')->findoRFail($request->state_id);

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
        $carts    = Cart::content();
        $products = '';
        foreach ($carts as $product)
        {
            $products .= $product->name . ",";

        }

        $post_data                 = [];
        $post_data['total_amount'] = $amount; # You cant not pay less than 10
        $post_data['currency']     = "BDT";
        $post_data['tran_id']      = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name']     = $request->name;
        $post_data['cus_email']    = $request->email;
        $post_data['cus_add1']     = $request->address1;
        $post_data['cus_add2']     = $request->address2;
        $post_data['cus_city']     = $state->district->name;
        $post_data['cus_state']    = $state->name;
        $post_data['cus_postcode'] = $request->post_code;
        $post_data['cus_country']  = "Bangladesh";
        $post_data['cus_phone']    = $request->phone;
        $post_data['cus_fax']      = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name']     = $request->name;
        $post_data['ship_add1']     = $request->address1;
        $post_data['ship_add2']     = $request->address2;
        $post_data['ship_city']     = $state->district->name;
        $post_data['ship_state']    = $state->name;
        $post_data['ship_postcode'] = $request->post_code;
        $post_data['ship_phone']    = $request->phone;
        $post_data['ship_country']  = "Bangladesh";

        $post_data['shipping_method']  = "NO";
        $post_data['product_name']     = rtrim($products, ',');
        $post_data['product_category'] = "Goods";
        $post_data['product_profile']  = "physical-goods";

        #Before  going to initiate the payment order status need to insert or update as Pending.
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
            'payment_method'  => 'SSLCommerz',
            'transaction_id'  => $post_data['tran_id'],
            'currency'        => "BDT",
            'amount'          => $amount,
            'shipping_cost'   => $request->shipping_cost,
            'coupon_discount' => $discount,
            'order_number'    => $post_data['tran_id'],
            'invoice_no'      => $invoice,
            'order_date'      => Carbon::now()->format('d F Y'),
            'order_month'     => Carbon::now()->format('F'),
            'order_year'      => Carbon::now()->format('Y'),
            'notes'           => $request->notes,
            'created_at'      => Carbon::now(),
        ]);

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

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options))
        {
            print_r($payment_options);
            $payment_options = [];
        }
    }
    //SSLCommerz Eassy
    public function sslcommerzEassy(Request $request)
    {

    }
    public function success(Request $request)
    {

        $tran_id  = $request->input('tran_id');
        $amount   = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'pending')
        {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation)
            {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                 */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'processing']);

                echo "<br >Transaction is successfully Completed";
            }
            else
            {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                 */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                echo "validation Fail";
            }
        }
        else if ($order_detials->status == 'processing' || $order_detials->status == 'complete')
        {
            /*
            That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed";
        }
        else
        {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }

    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'pending')
        {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        }
        else if ($order_detials->status == 'processing' || $order_detials->status == 'complete')
        {
            echo "Transaction is already Successful";
        }
        else
        {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'pending')
        {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        }
        else if ($order_detials->status == 'processing' || $order_detials->status == 'complete')
        {
            echo "Transaction is already Successful";
        }
        else
        {
            echo "Transaction is Invalid";
        }

    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id'))
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'pending')
            {
                $sslc       = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == true)
                {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                     */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'processing']);

                    echo "Transaction is successfully Completed";
                }
                else
                {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                     */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }

            }
            else if ($order_details->status == 'processing' || $order_details->status == 'complete')
            {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            }
            else
            {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        }
        else
        {
            echo "Invalid Data";
        }
    }

}