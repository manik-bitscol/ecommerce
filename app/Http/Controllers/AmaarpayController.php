<?php

    namespace App\Http\Controllers;

    use App\Mail\OrderMail;
    use App\Models\Option;
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

    class AmaarpayController extends Controller
    {
        public function index(Request $request)
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
            $amaarpayStoreId      = Option::where('key', '=', 'aamaypay_store_id')->first();
            $amaarpaySingatureKey = Option::where('key', '=', 'aamaypay_signature_key')->first();
            $fields               = [
                'store_id'      => $amaarpayStoreId->value,
                'amount'        => $amount, //transaction amount
                'payment_type' => 'VISA', //no need to change
                'currency'   => 'BDT', //currenct will be USD/BDT
                'tran_id'       => uniqid(),
                'cus_name'      => $request->name, //customer name
                'cus_email'    => $request->email, //customer email address
                'cus_add1'   => $request->address1, //customer address
                'cus_add2'      => $request->address2, //customer address
                'cus_city' => $state->district->name, //customer city
                'cus_state' => $state->name, //state
                'cus_postcode' => $request->post_code, //postcode or zipcode
                'cus_country' => 'Bangladesh', //country
                'cus_phone' => $request->phone, //customer phone number
                'cus_fax' => 'Not¬Applicable', //fax
                'ship_name' => $request->name, //ship name
                'ship_add1' => $request->address1, //ship address
                'ship_add2' => $request->address2,
                'ship_city'     => $request->phone,
                'ship_state'    => $request->phone,
                'ship_postcode' => $request->post_code,
                'ship_country'  => 'Bangladesh',
                'desc'          => 'payment description',
                'success_url'   => route('amaarpay.success'), //your success route
                'fail_url'     => route('amaarpay.fail'), //your fail route
                'cancel_url' => 'http://localhost/foldername/cancel.php', //your cancel url
                'signature_key' => $amaarpaySingatureKey->value,
            ]; //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key

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
                'payment_method'  => 'AmaarPay',
                'transaction_id'  => $fields['tran_id'],
                'currency'        => "BDT",
                'amount'          => $amount,
                'shipping_cost'   => $request->shipping_cost,
                'coupon_discount' => $discount,
                'order_number'    => $fields['tran_id'],
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

            Cart::destroy();

            Mail::to($request->email)->send(new OrderMail($mailInfo));
            if (Session::has('coupon'))
            {
                Session::forget('coupon');
            }

            $url = 'https://sandbox.aamarpay.com/request.php'; // live url https://secure.aamarpay.com/request.php

            $fields_string = http_build_query($fields);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
            curl_close($ch);

            $this->redirect_to_merchant($url_forward);
        }
        public function redirect_to_merchant($url)
        {

        ?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <script type="text/javascript">
    function closethisasap() {
        document.forms["redirectpost"].submit();
    }
    </script>
</head>

<body onLoad="closethisasap();">

    <form name="redirectpost" method="post" action="<?php echo 'https://sandbox.aamarpay.com/' . $url; ?>"></form>
    <!-- for live url https://secure.aamarpay.com -->
</body>

</html>
<?php
    exit;
        }

        public function success(Request $request)
        {
            // return dd($request->all());
            $tran_id  = $request->input('mer_txnid');
            $amount   = $request->input('amount_original');
            $currency = $request->input('currency_merchant');
            #Check order status in order tabel against the transaction id or order id.

            $order_detials = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_detials->status == 'pending')
            {

                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'confirmed']);

                return redirect()->route('home')->withSuccess('Payment Completed Successfully');

            }
            else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete')
            {
                /*
                That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
                 */
                return redirect()->route('home')->withSuccess('Payment Completed Successfully');
            }
            else
            {
                #That means something wrong happened. You can redirect customer to your product page.
                echo "Invalid Transaction";
            }
        }

        public function fail(Request $request)
        {
            return dd($request->all());
    }
}