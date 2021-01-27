@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-user.css') }}">
@endsection

@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter start -->
        <div class="card">
            <h5 class="card-header">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center mx-50 row pt-0 pb-2">
                <div class="col-md-4 filter_apartment"></div>
            </div>
        </div>
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="user-list-table table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>Rate</th>
                            <th>Price</th>
                            <th>Apartment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Modal to add new user starts-->
            <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                <div class="modal-dialog new-user-modal-dialog">
                    <form class="modal-content pt-0" method="POST" action="{{route('creates-rate')}}">
                        @csrf
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">New Rate</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-icon-default-rate">Rate</label>
                                <input type="text" inputmode="text" class="form-control dt-rate" id="basic-icon-default-rate" placeholder="Weekend Rate" name="name" required />
                            </div>
                            <div class="input-group w-100 mb-3">
                                <label class="form-label" for="amount">Price</label>
                                <input type="text" id="amount" name="amount" class="touchspin input-group-lg" value="{number}" />
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="apartment">Apartment</label>
                                <select class="select2 w-100" id="apartment" name="apartment">
                                    <option label=" "></option>
                                    @foreach ($apartments as $apartment)
                                    <option value="{{$apartment->id}}">{{$apartment->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <button type="reset" class="btn btn-outline-secondary mr-1" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal to add new user Ends-->
        </div>
        <!-- list section end -->
    </section>
    <!-- users list ends -->
@endsection

@section('vendor-js')
    @parent
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/forms/select/select2.full.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}" defer></script>
@endsection

@section('page-js')
    <script src="{{ asset ('/app-assets/js/scripts/pages/app-rates-list.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/js/scripts/pages/page-knowledge-base.js')}}" defer></script>
    <script src="{{ asset ('/js/core.js') }}" defer></script>
    <script src="{{ asset ('/js/script.js') }}" defer></script>
    <script type="module" defer>
        $("#apartment").select2({
            placeholder: 'Select Apartment'
        });
        $('.touchspin').TouchSpin({
            buttondown_class: 'btn btn-primary',
            buttonup_class: 'btn btn-primary',
            buttondown_txt: feather.icons['minus'].toSvg(),
            buttonup_txt: feather.icons['plus'].toSvg(),
            max: 100000000000
        });
    </script>
    @include('partials.form-response')
@endsection