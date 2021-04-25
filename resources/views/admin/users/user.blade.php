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
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-invoice-list.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-user.css') }}">
@endsection

@section('content')
    <section class="app-user-view">
        <!-- User Card & Plan Starts -->
        <div class="row">
            <!-- User Card starts-->
            <div class="col-xl-12 col-lg-8 col-md-7">
                <div class="card user-card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-between">
                            <div class="col-xl-7 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                <div class="user-avatar-section">
                                    <div class="d-flex justify-content-start">
                                        @if (empty($user->image))
                                        <img class="img-fluid rounded" src="{{asset('/images/user.svg')}}" height="104" width="104" alt="User avatar" />
                                        @else
                                        <img class="img-fluid rounded" src="{{$user->image}}" style="height: 104px; width:104px" alt="User avatar" />
                                        @endif
                                        
                                        <div class="d-flex flex-column ml-1">
                                            <div class="user-info mb-1">
                                                <h4 class="mb-0">{{$user->name}}</h4>
                                                <span class="card-text">{{$user->email}}</span>
                                            </div>
                                            <form class="d-flex flex-wrap" action="{{route('delete-user', $user->id)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="/admin/edit-user/{{$user->id}}" class="btn btn-primary">Edit</a>
                                                <button type="submit" title="delete user" class="btn btn-outline-danger ml-1">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center user-total-numbers">
                                    <div class="d-flex align-items-center mr-2">
                                        <div class="color-box bg-light-primary">
                                            <i data-feather="dollar-sign" class="text-primary"></i>
                                        </div>
                                        <div class="ml-1">
                                            <h5 class="mb-0">23.3k</h5>
                                            <small>Monthly Sales</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="color-box bg-light-success">
                                            <i data-feather="trending-up" class="text-success"></i>
                                        </div>
                                        <div class="ml-1">
                                            <h5 class="mb-0">$99.87K</h5>
                                            <small>Annual Profit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-12 mt-2 mt-xl-0 d-flex justify-content-start">
                                <div class="user-info-wrapper">
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="check" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Status</span>
                                        </div>
                                        <p class="card-text mb-0">{{$user->status}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="star" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Role</span>
                                        </div>
                                        <p class="card-text mb-0">{{$user->type}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="flag" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Address</span>
                                        </div>
                                        <p class="card-text mb-0">{{$user->address}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="user-info-title">
                                            <i data-feather="phone" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Contact</span>
                                        </div>
                                        <p class="card-text mb-0">{{$user->phone}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card Ends-->
        </div>
        <!-- User Card & Plan Ends -->

        <div class="col-xl-12 col-lg-8 col-md-7">
            <!-- User Permissions -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Permissions</h4>
                </div>
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
                                        @if($user->hasPermissionTo('view reservations'))
                                        <input type="checkbox" class="custom-control-input" id="reservations-read" value="view reservations" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="reservations-read" value="view reservations" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="reservations-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage reservations'))
                                        <input type="checkbox" class="custom-control-input" id="reservations-write" value="manage reservations" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="reservations-write" value="manage reservations" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="reservations-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create reservations'))
                                        <input type="checkbox" class="custom-control-input" id="reservations-create" value="create reservations" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="reservations-create" value="create reservations" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="reservations-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete reservations'))
                                        <input type="checkbox" class="custom-control-input" id="reservations-delete" value="delete reservations" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="reservations-delete" value="delete reservations" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="reservations-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Calendar</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('view calendars'))
                                        <input type="checkbox" class="custom-control-input" id="calendars-read" value="view calendars" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="calendars-read" value="view calendars" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="calendars-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage calendars'))
                                        <input type="checkbox" class="custom-control-input" id="calendars-write" value="manage calendars" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="calendars-write" value="manage calendars" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="calendars-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create calendars'))
                                        <input type="checkbox" class="custom-control-input" id="calendars-create" value="create calendars" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="calendars-create" value="create calendars" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="calendars-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete calendars'))
                                        <input type="checkbox" class="custom-control-input" id="calendars-delete" value="delete calendars" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="calendars-delete" value="delete calendars" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="calendars-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>User Management</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('view users'))
                                        <input type="checkbox" class="custom-control-input" id="users-read" value="view users" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="users-read" value="view users" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="users-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage users'))
                                        <input type="checkbox" class="custom-control-input" id="users-write" value="manage users" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="users-write" value="manage users" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="users-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create users'))
                                        <input type="checkbox" class="custom-control-input" id="users-create" value="create users" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="users-create" value="create users" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="users-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete users'))
                                        <input type="checkbox" class="custom-control-input" id="users-delete" value="delete users" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="users-delete" value="delete users" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="users-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Expense Mananagement</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('view expense'))
                                        <input type="checkbox" class="custom-control-input" id="expense-read" value="view expense" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="expense-read" value="view expense" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="expense-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage expense'))
                                        <input type="checkbox" class="custom-control-input" id="expense-write" value="manage expense" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="expense-write" value="manage expense" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="expense-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create expense'))
                                        <input type="checkbox" class="custom-control-input" id="expense-create" value="create expense" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="expense-create" value="create expense" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="expense-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete expense'))
                                        <input type="checkbox" class="custom-control-input" id="expense-delete" value="delete expense" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="expense-delete" value="delete expense" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="expense-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Revenue Management</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('view revenue'))
                                        <input type="checkbox" class="custom-control-input" id="revenue-read" value="view revenue" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="revenue-read" value="view revenue" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="revenue-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage revenue'))
                                        <input type="checkbox" class="custom-control-input" id="revenue-write" value="manage revenue" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="revenue-write" value="manage revenue" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="revenue-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create revenue'))
                                        <input type="checkbox" class="custom-control-input" id="revenue-create" value="create revenue" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="revenue-create" value="create revenue" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="revenue-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete revenue'))
                                        <input type="checkbox" class="custom-control-input" id="revenue-delete" value="delete revenue" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="revenue-delete" value="delete revenue" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="revenue-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Rate Management</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('view rate'))
                                        <input type="checkbox" class="custom-control-input" id="rate-read" value="view rate" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="rate-read" value="view rate" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="rate-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage rate'))
                                        <input type="checkbox" class="custom-control-input" id="rate-write" value="manage rate" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="rate-write" value="manage rate" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="rate-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create rate'))
                                        <input type="checkbox" class="custom-control-input" id="rate-create" value="create rate" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="rate-create" value="create rate" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="rate-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete rate'))
                                        <input type="checkbox" class="custom-control-input" id="rate-delete" value="delete rate" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="rate-delete" value="delete rate" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="rate-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Maintenance Module</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('view maintenance'))
                                        <input type="checkbox" class="custom-control-input" id="maintenance-read" value="view maintenance" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="maintenance-read" value="view maintenance" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="maintenance-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage maintenance'))
                                        <input type="checkbox" class="custom-control-input" id="maintenance-write" value="manage maintenance" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="maintenance-write" value="manage maintenance" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="maintenance-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create maintenance'))
                                        <input type="checkbox" class="custom-control-input" id="maintenance-create" value="create maintenance" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="maintenance-create" value="create maintenance" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="maintenance-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete maintenance'))
                                        <input type="checkbox" class="custom-control-input" id="maintenance-delete" value="delete maintenance" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="maintenance-delete" value="delete maintenance" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="maintenance-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Payroll/Settlement</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('view payroll'))
                                        <input type="checkbox" class="custom-control-input" id="payroll-read" value="view payroll" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="payroll-read" value="view payroll" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="payroll-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage payroll'))
                                        <input type="checkbox" class="custom-control-input" id="payroll-write" value="manage payroll" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="payroll-write" value="manage payroll" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="payroll-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create payroll'))
                                        <input type="checkbox" class="custom-control-input" id="payroll-create" value="create payroll" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="payroll-create" value="create payroll" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="payroll-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete payroll'))
                                        <input type="checkbox" class="custom-control-input" id="payroll-delete" value="delete payroll" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="payroll-delete" value="delete payroll" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="payroll-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Accounting</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('view accounting'))
                                        <input type="checkbox" class="custom-control-input" id="accounting-read" value="view accounting" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="accounting-read" value="view accounting" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="accounting-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage accounting'))
                                        <input type="checkbox" class="custom-control-input" id="accounting-write" value="manage accounting" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="accounting-write" value="manage accounting" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="accounting-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create accounting'))
                                        <input type="checkbox" class="custom-control-input" id="accounting-create" value="create accounting" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="accounting-create" value="create accounting" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="accounting-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete accounting'))
                                        <input type="checkbox" class="custom-control-input" id="accounting-delete" value="delete accounting" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="accounting-delete" value="delete accounting" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="accounting-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Blacklist</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('view blacklist'))
                                        <input type="checkbox" class="custom-control-input" id="blacklist-read" value="view blacklist" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="blacklist-read" value="view blacklist" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="blacklist-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('manage blacklist'))
                                        <input type="checkbox" class="custom-control-input" id="blacklist-write" value="manage blacklist" name="permissions[]" checked disabled>
                                        @endif
                                        <input type="checkbox" disabled class="custom-control-input" id="blacklist-write" value="manage blacklist" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="blacklist-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('create blacklist'))
                                        <input type="checkbox" class="custom-control-input" id="blacklist-create" value="create blacklist" name="permissions[]" disabled checked>   
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="blacklist-create" value="create blacklist" name="permissions[]" disabled>   
                                        <label class="custom-control-label" for="blacklist-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        @if($user->hasPermissionTo('delete blacklist'))
                                        <input type="checkbox" class="custom-control-input" id="blacklist-delete" value="delete blacklist" name="permissions[]" disabled checked>
                                        @endif
                                        <input type="checkbox" class="custom-control-input" id="blacklist-delete" value="delete blacklist" name="permissions[]" disabled>
                                        <label class="custom-control-label" for="blacklist-delete"></label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /User Permissions -->
        </div>

        <!-- User Invoice Starts-->
        <div class="row invoice-list-wrapper">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Reservations</h4>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="invoice-list-table table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Guest</th>
                                    <th>Room Type</th>
                                    <th>Expected Arrival</th>
                                    <th>Expected Departure</th>
                                    <th>Total</th>
                                    <th>Balance</th>
                                    <th>Payment Status</th>
                                    <th class="cell-fit">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /User Invoice Ends-->
    </section>
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
    <script src="{{ asset ('/js/user-view.js') }}" defer></script>
    @include('partials.form-response')
@endsection
