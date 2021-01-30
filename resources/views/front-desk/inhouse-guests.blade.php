@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset ('app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset ('app-assets/vendors/css/tables/datatable/responsive.bootstrap.min.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('app-assets/css/pages/app-invoice-list.css') }} ">
@endsection

@section('content')
<section class="invoice-list-wrapper">
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="inhouse-guest-table table">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Guest</th>
                        <th>Room Type</th>
                        <th>Expected Arrival</th>
                        <th>Total</th>
                        <th>Balance</th>
                        <th>Reserved On</th>
                        <th>Payment Status</th>
                        <th class="cell-fit">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
@endsection

@section('vendor-js')
    @parent
    <script src="{{ asset ('app-assets/vendors/js/extensions/moment.min.js') }}" defer></script>
    <script src="{{ asset ('app-assets/vendors/js/tables/datatable/datatables.min.js') }}" defer></script>
    <script src="{{ asset ('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}" defer></script>
    <script src="{{ asset ('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}" defer></script>
    <script src="{{ asset ('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}" defer></script>
    <script src="{{ asset ('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}" defer></script>
    <script src="{{ asset ('app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js') }}" defer></script>
@endsection

@section('page-js')
    @parent
    <script src="{{ asset('app-assets/js/scripts/pages/app-inhouse-list.js')}}" defer></script>
    @include('partials.form-response')
@endsection
