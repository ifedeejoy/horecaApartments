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

@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- users filter start -->
        <div class="card">
            <h5 class="card-header">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center mx-50 row pt-0 pb-2">
                <div class="col-md-4 user_role"></div>
                <div class="col-md-4 user_plan"></div>
                <div class="col-md-4 user_status"></div>
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
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Modal to add new user starts-->
            <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                <div class="modal-dialog new-user-modal-dialog">
                    <form class="modal-content pt-0" method="POST" action="{{route('creates-owner')}}">
                        @csrf
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">New User</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                                <input type="text" inputmode="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="John Doe" name="name" required />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-email">Email</label>
                                <input type="text" inputmode="email" id="basic-icon-default-email" class="form-control dt-email" placeholder="john.doe@example.com" name="email" required/>
                                <small class="form-text text-muted"> You can use letters, numbers & periods </small>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-phone">Phone</label>
                                <input type="text" inputmode="tel" id="basic-icon-default-phone" class="form-control dt-phone" placeholder="+234-903-521-7974" name="phone" required/>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-address">Address</label>
                                <input type="text" inputmode="text" class="form-control dt-full-name" id="basic-icon-default-address" placeholder="Lekki, Lagos" name="address" required />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="user-country">Country</label>
                                <select class="select2 w-100" id="user-country" name="country">
                                    <option label=" "></option>
                                    @include('partials.country-options')
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="user-type">Select Role</label>
                                <select id="user-type" name="type" class="form-control" required>
                                    <option value="agents">Agent</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="owner">Owner</option>
                                    <option value="property manager">Property Manager</option>
                                    <option value="staff">Staff</option>
                                    <option value="super-admin">Super Admin</option>
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
@endsection

@section('page-js')
    <script src="{{ asset ('/app-assets/js/scripts/pages/app-owner-list.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/js/scripts/pages/page-knowledge-base.js')}}" defer></script>
    <script type="module" defer>
        $("#user-country").select2({
            placeholder: 'Select Country'
        });
    </script>
    @include('partials.form-response')
@endsection
