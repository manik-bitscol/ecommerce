@extends('layouts.admin-layout')
@section('title', 'Picked Orders')
@section('order', 'active show-sub')
@section('picked', 'active')
@section('content')
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
        <span class="breadcrumb-item active">Picked Orders</span>
    </nav>

    <div class="sl-pagebody">
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="card pd-10 pd-sm-20">
                    <h6 class="card-body-title">Picked Orders</h6>
                    <table class="table responsive" id="order-table">
                        <thead>
                            <tr>
                                <th class="wd-20p">Picked Date</th>
                                <th class="wd-10p">Invoice</th>
                                <th class="wd-15p">Transaction ID</th>
                                <th class="wd-15p">Amount</th>
                                <th class="wd-5p">Status</th>
                                <th class="wd-20p">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="wd-20p">{{ Carbon\Carbon::parse($order->picked_date)->format('d-M-Y') }}</td>
                                    <td class="wd-10p">{{ $order->invoice_no }}</td>
                                    <td class="wd-15p">{{ $order->transaction_id }}</td>
                                    <td class="wd-15p">
                                        @if ($order->currency === 'usd')
                                            {{ $order->amount * 85 }}
                                        @else
                                            {{ $order->amount }}
                                        @endif
                                    </td>
                                    <td class="wd-5p"><span class="badge badge-primary">{{ $order->status }} </span></td>
                                    </td>
                                    <td class="wd-20p">
                                        <a href="{{ route('admin.order.detail', ['order_id' => $order->id]) }}"
                                            class="btn btn-success" title="View Product"><i class="fa fa-eye"></i>View
                                        </a>
                                        <button class="btn btn-warning cancel-btn" data-id={{ $order->id }}
                                            data-toggle="modal" data-target="#cancel-modal">
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('modal')
        <div id="cancel-modal" class="modal fade">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content bd-0 tx-14">
                    <form action="{{ route('admin.order.cancel') }}" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="modal-header pd-x-20">
                            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Order Cancel</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body pd-20">
                            <input type="hidden" name="order_id" id="order-id">
                            <label for="cancel-reaseon">Cancel Reason</label>
                            <textarea name="cancel_reason" id="cancel-reaseon" class="form-control" style="width: 250px"></textarea>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-info pd-x-20">Cancel Now</button>
                            <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div><!-- modal-dialog -->
        </div>
    @endpush
@endsection
@section('scripts')
    <script type="text/javascript">
        $('.cancel-btn').click(function() {
            let orderId = $(this).attr('data-id')
            $('#order-id').val(orderId);
        })
        $('#order-table').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });
    </script>
@endsection
