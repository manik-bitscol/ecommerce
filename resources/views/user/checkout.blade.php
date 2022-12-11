@extends('layouts.frontend-layout')
@section('title', 'Checkout Page')
@section('content')

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>Checkout</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="checkout-box">
                <form class="register-form" action="{{ route('shipping.store') }}" role="form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shipping-area">
                                        <h4 class="checkout-subtitle">Shipping Area</h4>
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="info-title" for="name">Name
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control unicase-form-control text-input" name="name"
                                                        id="name" placeholder="Enter Your Full Name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="email">Email Address
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="email" name="email"
                                                        class="form-control unicase-form-control text-input" id="email"
                                                        placeholder="Enter Email Address">
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="phone">Phone Number
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="phone"
                                                        class="form-control unicase-form-control text-input" id="phone"
                                                        placeholder="Enter Your Phone Number">
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="address1">Address 1 (House/Road/Holding)
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control unicase-form-control text-input" name="address1"
                                                        id="address1" placeholder="Enter Your Address 1">
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="address2">Address 2 (House/Road/Holding)
                                                    </label>
                                                    <input type="text"
                                                        class="form-control unicase-form-control text-input" name="address2"
                                                        id="address2" placeholder="Enter Your Address 2">
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="phone">Select Division
                                                        <span class="text-danger">*</span></label>
                                                    <select name="division_id"
                                                        class="form-control select2 select2-show-search unicase-form-control"
                                                        id="division">
                                                        <option value="">Choose One Division</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-6 col-12">

                                                <div class="form-group">
                                                    <label class="info-title" for="phone">Select District
                                                        <span class="text-danger">*</span></label>
                                                    <select name="district_id"
                                                        class="form-control select2 select2-show-search unicase-form-control"
                                                        id="district">
                                                    </select>
                                                </div>


                                                <div class="form-group">
                                                    <label class="info-title" for="phone">Select Thana
                                                        <span class="text-danger">*</span></label>
                                                    <select name="state_id"
                                                        class="form-control select2 select2-show-search unicase-form-control"
                                                        id="state">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="post-code">Post Code
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control unicase-form-control text-input"
                                                        name="post_code" id="post-code" placeholder="Enter Your Post Code">
                                                </div>


                                                <div class="form-group">
                                                    <label class="info-title" for="phone">Shipping Cost
                                                        <span class="text-danger">*</span></label>
                                                    <select name="shipping_cost" class="form-control unicase-form-control"
                                                        id="shipping-cost" required>
                                                        <option value="">Select Shipping Cost</option>
                                                        @foreach ($costs as $cost)
                                                            <option value="{{ $cost->cost }}">
                                                                {{ $cost->area_name }}-{{ $cost->cost }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">Notes </label>
                                                    <textarea name="notes" id="phone" class="form-control unicase-form-control"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-success">Save</button>

                                            </div>

                                        </div>
                                        <div class="col-md-12">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">

                                <div class="col-md-12">
                                    <!-- checkout-progress-sidebar -->
                                    <div class="checkout-progress-sidebar ">
                                        <div class="panel-group">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="unicase-checkout-title">Choose Your Payment Method</h4>
                                                </div>
                                                <div class="">
                                                    <ul>
                                                        <li>
                                                            <input type="radio" name="payment_method" id="stripe"
                                                                value="stripe">
                                                            <label for="stripe">Stripe</label>
                                                        </li>

                                                        <li>
                                                            <input type="radio" name="payment_method" id="amaarpay"
                                                                value="amaarpay">
                                                            <label for="amaarpay">AmaarPay</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" name="payment_method"
                                                                id="sslcommerz-hosted" value="sslcommerz_hosted">
                                                            <label for="sslcommerz-hosted">SSLCommerz(HostedPay)</label>
                                                        </li>

                                                        <li>
                                                            <input type="radio" name="payment_method" id="cod"
                                                                value="cod">
                                                            <label for="cod">Cash On Delivey</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- checkout-progress-sidebar -->
                                </div>
                                <div class="col-md-12">
                                    <!-- checkout-progress-sidebar -->
                                    <div class="checkout-progress-sidebar ">
                                        <div class="panel-group">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="unicase-checkout-title">Your Checkout Progress</h4>
                                                </div>
                                                <div class="">
                                                    <table class="table">
                                                        <tbody>
                                                            @foreach ($cartProducts as $product)
                                                                <tr>
                                                                    <td style="padding: 0">
                                                                        <div style="width:100px;">
                                                                            <img style="width:100%;"
                                                                                src="{{ asset($product->options->image) }}">
                                                                        </div>
                                                                    </td>
                                                                    <td style="padding: 0">{{ $product->name }}</td>
                                                                    <td style="padding: 0;color:rgb(6, 168, 6);">
                                                                        ৳{{ $product->price }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="">
                                                    @if (session()->has('coupon'))
                                                        <div class="cart-sub-total" style="font-size: 18px">
                                                            Subtotal<span class="inner-left-md">৳{{ $subtotal }}</span>
                                                        </div>
                                                        <div class="cart-grand-total" style="font-size: 20px">
                                                            Total:
                                                            <span class="inner-left-md" style="color:rgb(6, 168, 6);"
                                                                id="grand-total">৳{{ $total }}</span>
                                                        </div>
                                                    @else
                                                        <div class="cart-grand-total" style="font-size: 20px">
                                                            Total:<span class="inner-left-md"
                                                                style="color:rgb(6, 168, 6);"
                                                                id="grand-total">৳{{ $total }}</span>
                                                        </div>
                                                    @endif


                                                    <input type="hidden" id="total-amount" value="{{ $total }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- checkout-progress-sidebar -->
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->
                </form>
            </div><!-- /.checkout-box -->

        </div><!-- /.container -->
    </div><!-- /.body-content -->

@endsection
@section('scripts')
    <script type="text/javascript">
        function getAllDivision() {
            axios.get("{{ url('/user/checkout/division') }}")
                .then(function(response) {
                    if (response.status === 200) {
                        $.each(response.data.divisions, function(id, division) {
                            $('#division').append(
                                '<option value="' + division.id + '">' + division.name + '</option>'
                            )
                        })
                    }
                })
                .catch(function(error) {
                    console.log(error);
                })
        }
        getAllDivision();
        $('#division').on('change', function() {
            let divisionId = $('#division').val();
            axios.get("{{ url('/user/checkout/district') }}/" + divisionId)
                .then(function(response) {
                    console.log(response.data.districts);
                    if (response.status === 200) {
                        $('#district').empty();
                        $('#district').append(
                            '<option value="">Choose One</option>'
                        )
                        $.each(response.data.districts, function(id, district) {
                            $('#district').append(
                                '<option value="' + district.id + '">' + district.name + '</option>'
                            )
                        })
                    }
                })
                .catch(function(error) {
                    console.log(error);
                })
        })
        $('#district').on('change', function() {
            let districtId = $('#district').val();
            axios.get("{{ url('/user/checkout/state') }}/" + districtId)
                .then(function(response) {
                    if (response.status === 200) {
                        $('#state').empty();
                        $('#state').append(
                            '<option value="">Choose One</option>'
                        )
                        $.each(response.data.states, function(id, state) {
                            $('#state').append(
                                '<option value="' + state.id + '">' + state.name + '</option>'
                            )
                        })
                    }
                })
                .catch(function(error) {
                    console.log(error);
                })
        })
        $('#shipping-cost').on('change', function() {
            if ($('#shipping-cost').val() == '') {
                let totalAmount = $('#total-amount').val();
                $('#grand-total').html("৳ " + totalAmount);
            } else {
                let shippingCost = $('#shipping-cost').val();
                let totalAmount = $('#total-amount').val();
                let grandTotal = parseInt(shippingCost) + parseInt(totalAmount);
                $('#grand-total').html("৳ " + grandTotal);
            }
        });
    </script>
@endsection
