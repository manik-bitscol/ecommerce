@extends('layouts.admin-layout')
@section('title', 'Edit Shipping Cost')
@section('cost', 'active')
@section('content')
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
        <a class="breadcrumb-item" href="{{ route('admin.shipping.cost') }}">{{ __('Shipping Cost') }}</a>
        <span class="breadcrumb-item active">Edit Shipping Cost</span>
    </nav>

    <div class="sl-pagebody">
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="card pd-10 pd-sm-20">
                    <h6 class="card-body-title">Edit Shipping Cost</h6>
                    <form action="{{ route('admin.shipping.cost.update', $cost->id) }}" class="form-layout" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">Coupon Code: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="area_name" value="{{ $cost->area_name }}"
                                placeholder="Enter Coupon Code">
                            @error('area_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Shipping Cost: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="cost" value="{{ $cost->cost }}"
                                placeholder="Enter Shipping Cost" required>
                            @error('cost')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-layout-footer">
                            <button class="btn btn-info mg-r-5">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        @if (session()->has('error'))
            Swal.fire({
                icon: 'error',
                text: "{{ session('error') }}"
            })
        @endif
    </script>
@endsection
