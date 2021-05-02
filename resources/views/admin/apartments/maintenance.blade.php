@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/editors/quill/quill.snow.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-user.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/form-quill-editor.css') }}">
@endsection

@section('content-header')
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Maintenance</h2>
                <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/home">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Maintenance
                    </li>
                </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="grid"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="/admin/apartments">
                        <i class="mr-1" data-feather="check-square"></i>
                        <span class="align-middle">Apartments</span>
                    </a>
                    <a class="dropdown-item" href="/admin/rates">
                        <i class="mr-1" data-feather="briefcase"></i>
                        <span class="align-middle">Rates</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <sections>
        <div class="card">
            <h5 class="card-header">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center mx-50 row pt-0 pb-2">
                <div class="col-md-4 filter_apartment"></div>
            </div>
        </div>
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
        </div>
    </section>
    <!-- Modal to report maintenance issue starts-->
    <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
        <div class="modal-dialog new-user-modal-dialog">
            <form class="modal-content pt-0" method="POST" action="{{route('creates-rate')}}">
                @csrf
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">New Issue</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="form-group">
                        <label class="form-label" for="apartment">Apartment</label>
                        <select class="select2 w-100" id="apartment" name="apartment">
                            <option label=" "></option>
                            @foreach ($apartments as $apartment)
                            <option value="{{$apartment->id}}">{{$apartment->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quill-editor" class="form-label">Issue</label>
                        <div id="quill-editor">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="vendor-search">Select Vendor</label>
                        <select class="select2 w-100" id="vendor-search" data-placeholder="Search for vendor" onchange="selectVendor(this.value)">
                            <option label=" "></option>
                            <option value="new-vendor">Add new vendor</option>
                            @foreach ($vendors as $vendor)
                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-name">Vendor Name</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-name" placeholder="Mr Ochuko" disabled name="name">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-phone">Vendor Phone</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-phone" placeholder="+234902993882" disabled name="phone">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-email">Vendor Email</label>
                        <input type="email" inputmode="text" class="form-control d-none vendor-info" id="vendor-email" placeholder="ochukoandsons@gmail.com" disabled name="email">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-address">Address</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-address" placeholder="Lekki, Lagos" disabled name="address">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-business-name">Business Name</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-business-name" placeholder="Ochuko & Sons Enterpises" disabled name="business-name">
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="reset" class="btn btn-outline-secondary mr-1" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal to report maintenance issue Ends-->s
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
    <script src="{{ asset ('/app-assets/vendors/js/editors/quill/quill.min.js') }}" defer></script>
@endsection

@section('page-js')
    <script src="{{ asset ('/app-assets/js/scripts/forms/form-quill-editor.js') }}" defer></script>
    <script src="{{ asset ('/js/maintenance-list.js') }}" defer></script>
    <script src="{{ asset ('/js/core.js') }}" defer></script>
    <script type="module" defer>
        $("#apartment").select2({
            placeholder: 'Select Apartment'
        })
        $("#vendor-search").select2({
            placeholder: 'Select Vendor'
        })
        let editor = new Quill('#quill-editor', {
            placeholder: 'Description',
            theme: 'snow'
        })
    </script>
    @include('partials.form-response')
@endsection