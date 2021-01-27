@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ secure_asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ secure_asset ('app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet" href="{{ secure_asset ('app-assets/css/pages/app-user.css') }}">
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
                            <th>Plan</th>
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
                                <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="John Doe" name="name" required />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-email">Email</label>
                                <input type="text" id="basic-icon-default-email" class="form-control dt-email" placeholder="john.doe@example.com" name="email" required/>
                                <small class="form-text text-muted"> You can use letters, numbers & periods </small>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="user-type">User Type</label>
                                <select id="user-type" name="type" class="form-control" required>
                                    <option value="Agent">Agent</option>
                                    <option value="Accountant">Accountant</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Owner">Owner</option>
                                    <option value="Property Manager">Property Manager</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label" for="user-department">Select Department</label>
                                <select id="user-department" name="department" class="form-control" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Account">Account</option>
                                    <option value="FrontDesk">Front Desk</option>
                                    <option value="FandB">Food and Beverage</option>
                                    <option value="Housekeeping">Housekeeping/Maintenance</option>
                                </select>
                            </div>
                            <p class="card-text ml-2">Permission according to role</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-borderless">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Module</th>
                                            <th>View</th>
                                            <th>Manage</th>
                                            <th>Create</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Reservations</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="reservations-read" value="view reservations" name="permissions[]" checked/>
                                                    <label class="custom-control-label" for="reservations-read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="reservations-write" value="manage reservations" name="permissions[]" />
                                                    <label class="custom-control-label" for="reservations-write"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="reservations-create" value="create reservations" name="permissions[]"/>
                                                    <label class="custom-control-label" for="reservations-create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="reservations-delete" value="delete reservations" name="permissions[]"/>
                                                    <label class="custom-control-label" for="reservations-delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>User Management</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="users-read" name="permissions[]" value="view users"/>
                                                    <label class="custom-control-label" for="users-read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="users-write" name="permissions[]" value="manage users"/>
                                                    <label class="custom-control-label" for="users-write"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="users-create" name="permissions[]" value="create users"/>
                                                    <label class="custom-control-label" for="users-create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="users-delete" name="permissions[]" value="delete users"/>
                                                    <label class="custom-control-label" for="users-delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Expense Mananagement</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="expense-read" value="view expense" name="permissions[]"/>
                                                    <label class="custom-control-label" for="expense-read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="expense-write" value="manage expense" name="permissions[]" />
                                                    <label class="custom-control-label" for="expense-write"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="expense-create" value="create expense" name="permissions[]" />
                                                    <label class="custom-control-label" for="expense-create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="expense-delete" value="delete expense" name="permissions[]" />
                                                    <label class="custom-control-label" for="expense-delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Revenue Management</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="revenue-read" value="view revenue" name="permissions[]"/>
                                                    <label class="custom-control-label" for="revenue-read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="revenue-write" value="manage revenue" name="permissions[]"/>
                                                    <label class="custom-control-label" for="revenue-write"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="revenue-create" value="create revenue" name="permissions[]"/>
                                                    <label class="custom-control-label" for="revenue-create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="revenue-delete" value="delete revenue" name="permissions[]"/>
                                                    <label class="custom-control-label" for="revenue-delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Rate Management</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="rate-read" name="permissions[]" value="view rate"/>
                                                    <label class="custom-control-label" for="rate-read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="rate-write"  name="permissions[]" value="manage rate"/>
                                                    <label class="custom-control-label" for="rate-write"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="rate-create"  name="permissions[]" value="create rate"/>
                                                    <label class="custom-control-label" for="rate-create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="rate-delete"  name="permissions[]" value="delete rate"/>
                                                    <label class="custom-control-label" for="rate-delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Maintenance Module</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="maintenance-read" name="permissions[]" value="view maintenance"/>
                                                    <label class="custom-control-label" for="maintenance-read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="maintenance-write" name="permissions[]"  value="manage maintenance"/>
                                                    <label class="custom-control-label" for="maintenance-write"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="maintenance-create" name="permissions[]"  value="create maintenance"/>
                                                    <label class="custom-control-label" for="maintenance-create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="maintenance-delete" name="permissions[]"  value="delete maintenance"/>
                                                    <label class="custom-control-label" for="maintenance-delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Payroll/Settlement</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="payroll-read" value="view payroll" name="permissions[]"/>
                                                    <label class="custom-control-label" for="payroll-read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="payroll-write" value="manage payroll" name="permissions[]"/>
                                                    <label class="custom-control-label" for="payroll-write"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="payroll-create" value="create payroll" name="permissions[]"/>
                                                    <label class="custom-control-label" for="payroll-create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="payroll-delete" value="delete payroll" name="permissions[]"/>
                                                    <label class="custom-control-label" for="payroll-delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Accounting</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="accounting-read" name="permissions[]" value="view accounting"/>
                                                    <label class="custom-control-label" for="accounting-read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="accounting-write" name="permissions[]" value="manage accounting"/>
                                                    <label class="custom-control-label" for="accounting-write"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="accounting-create" name="permissions[]" value="create accounting"/>
                                                    <label class="custom-control-label" for="accounting-create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="accounting-delete" name="permissions[]" value="delete accounting"/>
                                                    <label class="custom-control-label" for="accounting-delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Blacklist</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="blacklist-read" name="permissions[]" value="view blacklist"/>
                                                    <label class="custom-control-label" for="blacklist-read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="blacklist-write" name="permissions[]" value="manage blacklist"/>
                                                    <label class="custom-control-label" for="blacklist-write"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="blacklist-create" name="permissions[]" value="create blacklist"/>
                                                    <label class="custom-control-label" for="blacklist-create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="blacklist-delete" name="permissions[]" value="delete blacklist"/>
                                                    <label class="custom-control-label" for="blacklist-delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
    <script src="{{ secure_asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ secure_asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}" defer></script>
    <script src="{{ secure_asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}" defer></script>
    <script src="{{ secure_asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}" defer></script>
    <script src="{{ secure_asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}" defer></script>
    <script src="{{ secure_asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}" defer></script>
    <script src="{{ secure_asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}" defer></script>
@endsection

@section('page-js')
    <script src="{{ secure_asset('app-assets/js/scripts/pages/app-user-list.js') }}" defer></script>
    <script src="{{ secure_asset('app-assets/js/scripts/pages/page-knowledge-base.js')}}" defer></script>
    @include('partials.form-response')
@endsection
