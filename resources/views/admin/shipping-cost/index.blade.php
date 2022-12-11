@extends('layouts.admin-layout')
@section('title', 'Shipping Costs')
@section('cost', 'active')
@section('content')
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
        <span class="breadcrumb-item active">Shipping Cost</span>
    </nav>

    <div class="sl-pagebody">
        <div class="row row-sm">
            <div class="col-md-8">
                <div class="card pd-10 pd-sm-20">
                    <h6 class="card-body-title">Shipping Costs</h6>
                    <div class="table-wrapper">
                        <table class="table display responsive nowrap" id="brand-table">
                            <thead>
                                <tr>
                                    <th>SI</th>
                                    <th>Area Name</th>
                                    <th>Cost(TK)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $start = 0;
                                @endphp
                                @forelse ($shippingAreas as $shippingArea)
                                    <tr>
                                        <td>{{ ++$start }}</td>
                                        <td>{{ $shippingArea->area_name }}</td>
                                        <td>{{ $shippingArea->cost }}</td>

                                        <td>
                                            <a href="{{ route('admin.shipping.cost.edit', $shippingArea->id) }}"
                                                class="btn btn-primary" title="Edit Brand">Edit</a>
                                            <a href="{{ route('admin.shipping.cost.delete', $shippingArea->id) }}"
                                                class="btn btn-danger" id="delete" title="Delete Brand">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card pd-10 pd-sm-20">
                    <h6 class="card-body-title">Add New Shipping Area</h6>
                    <form action="{{ route('admin.shipping.cost.store') }}" class="form-layout" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">Area Name: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="area_name" value="{{ old('area_name') }}"
                                placeholder="Enter Area Name" required>
                            @error('area_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Shipping Cost: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="number" name="cost" value="{{ old('cost') }}"
                                placeholder="Enter Shipping Cost" required>
                            @error('cost')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-layout-footer">
                            <button class="btn btn-info mg-r-5">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#brand-table').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            let link = $(this).attr('href');
            Swal.fire({
                title: "Are your sure want to Delete !",
                text: 'Once deleted, you will not be able to recover',
                icon: 'warning',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Don't Delete`,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    window.location.href = link;
                } else {
                    Swal.fire('Your Brand is safe', '', 'info')
                }
            })
        });
        @if (session()->has('success'))
            Swal.fire({
                icon: 'success',
                text: "{{ session('success') }}"
            })
        @endif
        @if (session()->has('error'))
            Swal.fire({
                icon: 'error',
                text: "{{ session('error') }}"
            })
        @endif
    </script>
@endsection
