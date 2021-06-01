@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-user.css') }}">
@endsection

@section('content-header')
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Maintenance</h2>
                <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/admin/maintenance">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Vendors
                    </li>
                </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block">
        <div class="form-group breadcrumb-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="grid"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#new-vendor">
                        <i class="mr-1" data-feather="check-square"></i>
                        <span class="align-middle">New Vendor</span>
                    </a>
                    <a class="dropdown-item" href="/admin/maintenance">
                        <i class="mr-1" data-feather="check-square"></i>
                        <span class="align-middle">Maintenance Issues</span>
                    </a>
                    <a class="dropdown-item" href="/admin/apartments">
                        <i class="mr-1" data-feather="briefcase"></i>
                        <span class="align-middle">Apartments</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section>
        <!-- list section start -->
        <div class="card p-1">
            <div class="card-datatable table-responsive pt-0">
                <table class="vendors-list-table text-center table" id="vendors-list-table">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Business Name</th>
                            <th>Vendor Type</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $vendor)
                        <tr>
                            <td>
                                <span class='text-truncate align-middle'>{{$vendor->id}}</span>
                            </td>
                            <td>
                                <span class='text-truncate align-middle'>{{$vendor->name}}</span>
                            </td>
                            <td>
                                <span class='text-truncate align-middle'>{{$vendor->business_name}}</span>
                            </td>
                            <td>
                                <span class='text-truncate align-middle text-capitalize'>
                                    <i class="font-medium-3 text-primary mr-50" data-feather="settings"></i> 
                                    {{$vendor->type}}
                                </span>
                            </td>
                            <td>
                                <span class='text-truncate align-middle'>{{$vendor->phone}}</span>
                            </td>
                            <td>
                                <span class='text-truncate align-middle'>{{$vendor->address}}</span>
                            </td>
                            <td>
                                <div class="btn-group"> 
                                    <a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown"> 
                                        <i data-feather="more-vertical"></i>
                                    </a> 
                                    <div class="dropdown-menu dropdown-menu-right"> 
                                        <a href="{{route('show-vendor', $vendor)}}" class="dropdown-item"> 
                                            <i data-feather="eye"></i>
                                            View Vendor
                                        </a> 
                                        <a href="#" class="dropdown-item"> 
                                            <i data-feather="edit-2"></i>
                                            Edit Vendor
                                        </a> 
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-vendor-{{$vendor->id}}').submit();"  class="dropdown-item delete-record"> 
                                            <i data-feather="trash-2"></i>
                                            Delete Vendor
                                        </a>
                                    </div> 
                                </div>
                            </td>
                        </tr>   
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- list section end -->
    </section>
    <!-- users list ends -->
    <!-- Modal to report maintenance issue starts-->
    <div class="modal modal-slide-in new-user-modal fade" id="new-vendor">
        <div class="modal-dialog new-user-modal-dialog">
            <form class="modal-content pt-0" method="POST" action="{{route('create-vendor')}}" enctype="multipart/form-data">
                @csrf
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">New Vendor</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="form-group">
                        <label class="form-label" for="vendor-name">Vendor Name</label>
                        <input type="text" inputmode="text" class="form-control vendor-info" id="vendor-name" placeholder="Mr Ochuko" name="name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="vendor-phone">Vendor Phone</label>
                        <input type="text" inputmode="text" class="form-control vendor-info" id="vendor-phone" placeholder="+234902993882" name="phone">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="vendor-email">Vendor Email</label>
                        <input type="email" inputmode="text" class="form-control vendor-info" id="vendor-email" placeholder="ochukoandsons@gmail.com" name="email">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="vendor-address">Address</label>
                        <input type="text" inputmode="text" class="form-control vendor-info" id="vendor-address" placeholder="Lekki, Lagos" name="address">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="vendor-business-name">Business Name</label>
                        <input type="text" inputmode="text" class="form-control vendor-info" id="vendor-business-name" placeholder="Ochuko & Sons Enterpises" name="business-name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="type">Vendor Type</label>
                        <select class="select2 w-100" id="vendor-type" name="type">
                            <option label=" "></option>
                            <option value="maintenance">Maintenance</option>
                            <option value="purchases">Purchases</option>
                            <option value="all">All</option>
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
@endsection

@section('page-js')
    <script src="{{ asset ('/js/core.js') }}" defer></script>
    <script src="{{ asset ('/js/vendors-list.js') }}" defer></script>
    @include('partials.form-response')
@endsection
