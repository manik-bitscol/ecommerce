{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"
        media="all">
    <style type="text/css">
        body {
            font-family: 'system-ui', 'sans-serif';
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: auto;
        }

        .p-3 {
            padding: 30px;
        }

        .bg {
            background-color: #f3f3f3;
        }

        .text-green {
            color: rgb(34, 182, 34);
        }

        /* table {
            width: 100%;
        } */

        .table {
            text-align: center;
            border-collapse: collapse
        }

        /* .table tr {

            width: 100%;
        } */

        .table th,
        .table td {
            border: 1px solid rgb(34, 182, 34);
            padding: 5px;
        }
    </style>
</head>

<body>

    <header class="header-section bg">
        <div class="container p-3">
            <div class="row">
                <div class="col-3">
                    <h2 style="font-size:30px;" class="text-green">Eassy Shop</h2>
                </div>
                <div class="col-3 offset-6">
                    <h3 style="font-size: 20px;" class="text-green">Eassy Shop Head Office</h3>
                    <p>Email: eassyshop@gmail.com</p>
                    <p>Phone: +8801959306576</p>
                    <p>Mirpur#10, Dhaka, Bangladesh</p>
                </div>
            </div>
        </div>
    </header>
    <section class="content-section bg">
        <div class="container p-3">
            <h3 style="font-size: 20px;" class="text-green">Shipping Information</h3>
            <hr>
            <div class="row">
                <div class="col-3">
                    <h4 style="font-size: 18px;" class="text-green">Invoice NO: {{ $order->invoice_no }}</h4>
                    <p>Name: {{ $order->name }}</p>
                    <p>Email: {{ $order->email }}</p>
                    <p>Phone: {{ $order->phone }}</p>
                </div>
                <div class="col-3 offset-6">
                    <p>Address: {{ $order->state->name }}, {{ $order->district->name }}, {{ $order->division->name }}
                    </p>
                    <p>Post Code: {{ $order->post_code }}</p>
                    <p>Order Date: {{ $order->order_date }}</p>
                    <p>Payment Method: {{ $order->payment_method }}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="product-info bg">
        <div class="container p-3">
            <div class="row">
                <div class="col-12">
                    <h3 style="font-size: 20px;" class="text-green">Products</h3>
                    <table class="table">
                        <thead>
                            <tr class="text-green">
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Discount</th>
                                <th>Price After Discount</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $orderItem)
                                <tr>
                                    <td style="width: 200px;">{{ $orderItem->product->product_name_en }}</td>
                                    <td style="width: 200px;">
                                        <img style="width: 100%;"
                                            src="{{ public_path($orderItem->product->product_thumbnail) }}"
                                            alt="">
                                    </td>
                                    <td>{{ $orderItem->product->product_color_en }}</td>
                                    <td>{{ $orderItem->product->product_size_en }}</td>
                                    <td>{{ $orderItem->qty }}</td>
                                    <td>{{ $orderItem->product->selling_price }}</td>
                                    <td>{{ ($orderItem->product->selling_price * $orderItem->product->discount) / 100 }}
                                    </td>
                                    <td>{{ $orderItem->price }}</td>
                                    <td>{{ $orderItem->price * $orderItem->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <h4 style="font-size: 25px;text-align:right;align-items: end;" class="text-green">Sub Total:
                        {{ $orderItems->sum('price') }} TK</h4>
                    @php
                        $couponDiscount = $orderItems->sum('price') - $order->amount;
                    @endphp
                    @if ($couponDiscount > 0)
                        <h4 style="font-size: 25px;text-align:right;align-items: end;" class="text-green">Coupon
                            Discount:
                            {{ $couponDiscount }} TK</h4>
                    @endif

                    <h4 style="font-size: 25px;text-align:right;align-items: end;" class="text-green">Total:
                        {{ $order->amount }} TK </h4>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer-section bg">
        <div class="container p-3">
            <div class="row">
                <div class="col-3">
                    <p>Thanks for buy product</p>
                </div>
                <div class="col-3 offset-6">
                    <p>---------------------------------------</p>
                    <p style="text-align: center">Authority Signature</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<div class="item-description">
                <div class="table-responsive">
                    <table class="custom--table">

                        <tbody>
                            <tr>

                                <td colspan="5" style="text-align: right">
                                    <span class="data-span"> {{ __('Package Fee:') }} </span>$80 <br>
                                    <span class="data-span"> {{ __('Extra Service:') }} </span>$20 <br>
                                    <span class="data-span"> {{ __('Sub Total:') }} </span>$100 <br>
                                    <span class="data-span"> {{ __('Tax:') }} </span>$10 <br>
                                    <span class="data-span"> {{ __('Coupon Amount:') }} </span>$5 <br>
                                    <span class="data-span"> {{ __('Total:') }} </span>$105 <br>
                                    <span class="data-span"> {{ __('Payment Status:') }} </span>{{ __('Pending') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
</html> --}}

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> {{ __('Billing Invoice - EPEC-Ecommerce') }} </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300&display=swap"
        rel="stylesheet">
</head>

<body>


    <style>
        * {
            font-family: 'Roboto', sans-serif;
            line-height: 26px;
            font-size: 15px;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        /*=====================[ Table ]=========================*/

        .custom--table {
            width: 100%;
            color: inherit;
            vertical-align: top;
            font-weight: 400;
            border-collapse: collapse;
            border-bottom: 2px solid #ddd;
            margin-top: 0;
        }

        .table-title {
            font-size: 24px;
            font-weight: 600;
            line-height: 32px;
            margin-bottom: 10px;
        }

        .custom--table thead {
            font-weight: 700;
            background: inherit;
            color: inherit;
            font-size: 13px;
            font-weight: 500;
        }

        .custom--table tbody {
            border-top: 0;
            overflow: hidden;
            border-radius: 10px;
        }

        .custom--table thead tr {
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
            text-align: left;
        }

        .custom--table thead tr th {
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
            text-align: left;
            font-size: 13px;
            padding: 10px 0;
        }

        .custom--table tbody tr {
            vertical-align: top;
        }

        .custom--table tbody tr td {
            font-size: 12px;
            line-height: 16px;
            vertical-align: top;
        }

        .custom--table tbody tr td:last-child {
            padding-bottom: 10px;
        }

        .custom--table tbody tr td .data-span {
            font-size: 12px;
            font-weight: 500;
            line-height: 16px;
        }

        .custom--table tbody .table_footer_row {
            border-top: 2px solid #ddd;
            margin-bottom: 10px !important;
            padding-bottom: 10px !important;

        }

        /* invoice area */
        .invoice-area {
            padding: 10px 0;
        }

        .invoice-wrapper {
            max-width: 650px;
            margin: 0 auto;
            box-shadow: 0 0 10px #f3f3f3;
            padding: 0px;
        }

        .invoice-header {
            margin-bottom: 40px;
        }

        .invoice-flex-contents {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }

        .invoice-logo {}

        .invoice-logo img {}

        .invoice-header-contents {
            float: right;
        }

        .invoice-header-contents .invoice-title {
            font-size: 40px;
            font-weight: 700;
        }

        .invoice-details {
            margin-top: 20px;
        }

        .invoice-details-flex {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }

        .invoice-details-title {
            font-size: 24px;
            font-weight: 700;
            line-height: 32px;
            color: #153568;
            margin: 0;
            padding: 0;
        }

        .invoice-single-details {}

        .details-list {
            margin: 0;
            padding: 0;
            list-style: none;
            margin-top: 10px;
        }

        .details-list .list {
            font-size: 12px;
            font-weight: 400;
            line-height: 18px;
            color: #666;
            margin: 0;
            padding: 0;
            transition: all .3s;
        }

        .details-list .list strong {
            font-size: 12px;
            font-weight: 500;
            line-height: 18px;
            color: #666;
            margin: 0;
            padding: 0;
            transition: all .3s;
        }

        .details-list .list a {
            display: inline-block;
            color: #666;
            transition: all .3s;
            text-decoration: none;
            margin: 0;
            line-height: 16px
        }

        .item-description {
            margin-top: 10px;
        }

        .products-item {
            text-align: left;
        }

        .invoice-total-count {}

        .invoice-total-count .list-single {
            display: flex;
            align-items: center;
            gap: 30px;
            font-size: 13px;
            line-height: 28px;
        }

        .invoice-total-count .list-single strong {}

        .invoice-subtotal {
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
        }

        .invoice-total {
            padding-top: 10px;
        }

        .terms-condition-content {
            margin-top: 30px;
        }

        .terms-flex-contents {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .terms-left-contents {
            flex-basis: 50%;
        }

        .terms-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin: 0;
        }

        .terms-para {
            margin-top: 10px;
        }

        .invoice-footer {}

        .invoice-flex-footer {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
        }

        .single-footer-item {
            flex: 1;
        }

        .single-footer {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .single-footer .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 30px;
            width: 30px;
            font-size: 14px;
            background-color: #000e8f;
            color: #fff;
        }

        .icon-details {
            flex: 1;
        }

        .icon-details .list {
            display: block;
            text-decoration: none;
            color: #666;
            transition: all .3s;
            line-height: 24px;
        }
    </style>

    <!-- Invoice area Starts -->
    <div class="invoice-area">
        <div class="invoice-wrapper">
            <div class="invoice-header">
                <div class="invoice-flex-contents">
                    <div class="invoice-logo">
                        <img src="{{ public_path($setting->logo) }}" alt="">
                    </div>
                    <div class="invoice-header-contents" style="float:right;margin-top:-120px;">
                        <h2 class="invoice-title">{{ __('INVOICE') }}</h2>
                    </div>
                </div>
            </div>
            <div class="invoice-details">
                <div class="invoice-details-flex">
                    <div class="invoice-single-details">
                        <h4 class="invoice-details-title">{{ $order->name }}</h4>
                        <ul class="details-list">
                            <li class="list"> <strong>Email: </strong> {{ $order->email }} </li>
                            <li class="list"> <strong>{{ __('Phone') }}: </strong> {{ $order->phone }} </li>
                            <li class="list"> <strong>{{ __('City') }}: </strong> {{ $order->state->name }} </li>
                            <li class="list"> <strong>{{ __('Address') }}:
                                </strong>{{ $order->address1 }} </li>
                        </ul>

                    </div>
                    <div class="invoice-single-details" style="float:right;margin-top:-120px;">

                        <ul class="details-list" style="text-align: right;">
                            <li class="list"> {{ $setting->address }} </li>
                            <li class="list">{{ $setting->email }} </li>
                            <li class="list">{{ $setting->phone_1 }}</li>
                            <li class="list">{{ $setting->phone_2 }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="invoice-details">
                <div class="invoice-details-flex">

                    <div class="invoice-single-details" style="float:right;margin-top:-120px;">
                        <ul class="details-list" style="text-align: right;">
                            <li class="list"> <strong>{{ __('Invoice No') }}: </strong> {{ $order->invoice_no }}
                            <li class="list"> <strong>{{ __('Order No') }}: </strong> {{ $order->id }}
                            <li class="list"> <strong>{{ __('Order Date') }}: </strong> {{ $order->order_date }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="item-description">
                <h3 style="font-size: 20px;" class="table-title">Products</h3>
                <table class="custom--table">
                    <thead>
                        <tr class="text-green">
                            <th>Product</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderItems as $orderItem)
                            <tr>
                                <td style="width: 100px">{{ $orderItem->product->product_name_en }}</td>
                                <td style="width: 50px">
                                    <img style="width: 100%;"
                                        src="{{ public_path($orderItem->product->product_thumbnail) }}" alt="">
                                </td>
                                <td>{{ $orderItem->qty }}</td>
                                <td>{{ $orderItem->product->selling_price }} TK</td>

                                <td>{{ $orderItem->price }}</td>
                                <td>{{ $orderItem->price * $orderItem->qty }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="">
                <div class="table-responsive" style="float:left;">

                    @if ($order?->notes)
                        <p> {{ $order?->notes }}</p>
                    @endif
                </div>
                <div class="table-responsive" style="float:right;">

                    @php
                        $total = intval($order->amount) + intval($order->coupon_discount) - intval($order->shipping_cost);
                        $subTotal = intval($total) + intval($order->shipping_cost);
                    @endphp
                    <div> {{ __('Total Price:') }} <span class="data-span">{{ $total }}</span> </div>
                    <div> {{ __('Shipping Cost:') }} <span class="data-span">{{ $order->shipping_cost }}</span> </div>
                    <div> {{ __('Sub Total:') }} <span class="data-span">{{ $subTotal }}</span> </div>
                    <div> {{ __('Coupon Amount:') }} <span class="data-span">{{ $order->coupon_discount }}</span>
                    </div>
                    <div> {{ __('Total Amount:') }} <span class="data-span">{{ $order->amount }}</span> </div>
                    @if ($order->payment_method === 'cod')
                        <div> {{ __('Payment DUE:') }} <span class="data-span">{{ $order->amount }}</span> </div>
                    @endif

                </div>
            </div>


            <footer>
                <h3 style="text-align: center">
                    {{-- {{ $data }} --}}
                </h3>
            </footer>

        </div>
    </div>

    <!-- Invoice area end -->

</body>

</html>
