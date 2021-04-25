@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset ('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet" href="{{ asset ('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-user.css') }}">
@endsection

@section('content')
    <!-- users edit start -->
    <section class="app-user-edit">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">
                            <i data-feather="user"></i><span class="d-none d-sm-block">Account</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" id="security-tab" data-toggle="tab" href="#security" aria-controls="security" role="tab" aria-selected="false">
                            <i data-feather="lock"></i><span class="d-none d-sm-block">Security</span>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" id="social-tab" data-toggle="tab" href="#social" aria-controls="social" role="tab" aria-selected="false">
                            <i data-feather="share-2"></i><span class="d-none d-sm-block">Social</span>
                        </a>
                    </li> --}}
                </ul>
                <div class="tab-content">
                    <!-- Account Tab starts -->
                    <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                        <!-- users edit account form start -->
                        <form class="form-validate" method="POST" action="{{route('update-user', $user->id)}}" enctype="multipart/form-data">
                            @csrf 
                            @method('PUT')
                            <!-- users edit media object start -->
                            <div class="media mb-2">
                                @if (empty($user->image))
                                <img src="{{asset('/images/user.svg')}}" alt="users avatar" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                @else 
                                <img src="{{$user->image}}" alt="users avatar" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                @endif
                                
                                <div class="media-body mt-50">
                                    <h4>{{$user->name}}</h4>
                                    <div class="col-12 d-flex mt-1 px-0">
                                        <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                            <span class="d-none d-sm-block">Change</span>
                                            <input class="form-control" type="file" id="change-picture" name="new-picture" hidden accept="image/png, image/jpeg, image/jpg" />
                                            <span class="d-block d-sm-none">
                                                <i class="mr-0" data-feather="edit"></i>
                                            </span>
                                        </label>
                                        <button class="btn btn-outline-secondary d-none d-sm-block">Remove</button>
                                        <button class="btn btn-outline-secondary d-block d-sm-none">
                                            <i class="mr-0" data-feather="trash-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- users edit media object ends -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" value="{{$user->name}}" name="name" id="name" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" value="{{$user->email}}" name="email" id="email" />
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" value="{{$user->phone}}" name="phone" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address-1">Address</label>
                                        <input id="address-1" type="text" class="form-control" value="{{$user->address}}" name="address" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status">
                                            <option>{{$user->status}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="{{$user->type}}">{{$user->type}}</option>
                                            <option value="agents">Agent</option>
                                            <option value="accountant">Accountant</option>
                                            <option value="owner">Owner</option>
                                            <option value="property manager">Property Manager</option>
                                            <option value="staff">Staff</option>
                                            <option value="super-admin">Super Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive border rounded mt-1">
                                        <h6 class="py-1 mx-1 mb-0 font-medium-2">
                                            <i data-feather="lock" class="font-medium-3 mr-25"></i>
                                            <span class="align-middle">Permission</span>
                                        </h6>
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
                                                            <input type="checkbox" class="custom-control-input" id="reservations-read" value="view reservations" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="reservations-read" value="view reservations" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="reservations-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage reservations'))
                                                            <input type="checkbox" class="custom-control-input" id="reservations-write" value="manage reservations" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="reservations-write" value="manage reservations" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="reservations-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create reservations'))
                                                            <input type="checkbox" class="custom-control-input" id="reservations-create" value="create reservations" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="reservations-create" value="create reservations" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="reservations-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete reservations'))
                                                            <input type="checkbox" class="custom-control-input" id="reservations-delete" value="delete reservations" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="reservations-delete" value="delete reservations" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="reservations-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Calendar</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('view calendars'))
                                                            <input type="checkbox" class="custom-control-input" id="calendars-read" value="view calendars" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="calendars-read" value="view calendars" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="calendars-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage calendars'))
                                                            <input type="checkbox" class="custom-control-input" id="calendars-write" value="manage calendars" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="calendars-write" value="manage calendars" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="calendars-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create calendars'))
                                                            <input type="checkbox" class="custom-control-input" id="calendars-create" value="create calendars" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="calendars-create" value="create calendars" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="calendars-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete calendars'))
                                                            <input type="checkbox" class="custom-control-input" id="calendars-delete" value="delete calendars" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="calendars-delete" value="delete calendars" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="calendars-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>User Management</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('view users'))
                                                            <input type="checkbox" class="custom-control-input" id="users-read" value="view users" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="users-read" value="view users" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="users-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage users'))
                                                            <input type="checkbox" class="custom-control-input" id="users-write" value="manage users" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="users-write" value="manage users" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="users-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create users'))
                                                            <input type="checkbox" class="custom-control-input" id="users-create" value="create users" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="users-create" value="create users" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="users-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete users'))
                                                            <input type="checkbox" class="custom-control-input" id="users-delete" value="delete users" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="users-delete" value="delete users" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="users-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Expense Mananagement</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('view expense'))
                                                            <input type="checkbox" class="custom-control-input" id="expense-read" value="view expense" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="expense-read" value="view expense" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="expense-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage expense'))
                                                            <input type="checkbox" class="custom-control-input" id="expense-write" value="manage expense" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="expense-write" value="manage expense" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="expense-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create expense'))
                                                            <input type="checkbox" class="custom-control-input" id="expense-create" value="create expense" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="expense-create" value="create expense" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="expense-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete expense'))
                                                            <input type="checkbox" class="custom-control-input" id="expense-delete" value="delete expense" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="expense-delete" value="delete expense" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="expense-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Revenue Management</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('view revenue'))
                                                            <input type="checkbox" class="custom-control-input" id="revenue-read" value="view revenue" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="revenue-read" value="view revenue" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="revenue-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage revenue'))
                                                            <input type="checkbox" class="custom-control-input" id="revenue-write" value="manage revenue" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="revenue-write" value="manage revenue" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="revenue-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create revenue'))
                                                            <input type="checkbox" class="custom-control-input" id="revenue-create" value="create revenue" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="revenue-create" value="create revenue" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="revenue-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete revenue'))
                                                            <input type="checkbox" class="custom-control-input" id="revenue-delete" value="delete revenue" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="revenue-delete" value="delete revenue" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="revenue-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Rate Management</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('view rate'))
                                                            <input type="checkbox" class="custom-control-input" id="rate-read" value="view rate" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="rate-read" value="view rate" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="rate-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage rate'))
                                                            <input type="checkbox" class="custom-control-input" id="rate-write" value="manage rate" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="rate-write" value="manage rate" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="rate-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create rate'))
                                                            <input type="checkbox" class="custom-control-input" id="rate-create" value="create rate" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="rate-create" value="create rate" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="rate-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete rate'))
                                                            <input type="checkbox" class="custom-control-input" id="rate-delete" value="delete rate" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="rate-delete" value="delete rate" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="rate-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Maintenance Module</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('view maintenance'))
                                                            <input type="checkbox" class="custom-control-input" id="maintenance-read" value="view maintenance" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="maintenance-read" value="view maintenance" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="maintenance-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage maintenance'))
                                                            <input type="checkbox" class="custom-control-input" id="maintenance-write" value="manage maintenance" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="maintenance-write" value="manage maintenance" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="maintenance-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create maintenance'))
                                                            <input type="checkbox" class="custom-control-input" id="maintenance-create" value="create maintenance" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="maintenance-create" value="create maintenance" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="maintenance-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete maintenance'))
                                                            <input type="checkbox" class="custom-control-input" id="maintenance-delete" value="delete maintenance" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="maintenance-delete" value="delete maintenance" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="maintenance-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Payroll/Settlement</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('view payroll'))
                                                            <input type="checkbox" class="custom-control-input" id="payroll-read" value="view payroll" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="payroll-read" value="view payroll" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="payroll-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage payroll'))
                                                            <input type="checkbox" class="custom-control-input" id="payroll-write" value="manage payroll" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="payroll-write" value="manage payroll" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="payroll-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create payroll'))
                                                            <input type="checkbox" class="custom-control-input" id="payroll-create" value="create payroll" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="payroll-create" value="create payroll" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="payroll-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete payroll'))
                                                            <input type="checkbox" class="custom-control-input" id="payroll-delete" value="delete payroll" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="payroll-delete" value="delete payroll" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="payroll-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Accounting</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('view accounting'))
                                                            <input type="checkbox" class="custom-control-input" id="accounting-read" value="view accounting" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="accounting-read" value="view accounting" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="accounting-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage accounting'))
                                                            <input type="checkbox" class="custom-control-input" id="accounting-write" value="manage accounting" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="accounting-write" value="manage accounting" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="accounting-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create accounting'))
                                                            <input type="checkbox" class="custom-control-input" id="accounting-create" value="create accounting" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="accounting-create" value="create accounting" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="accounting-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete accounting'))
                                                            <input type="checkbox" class="custom-control-input" id="accounting-delete" value="delete accounting" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="accounting-delete" value="delete accounting" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="accounting-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Blacklist</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('view blacklist'))
                                                            <input type="checkbox" class="custom-control-input" id="blacklist-read" value="view blacklist" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="blacklist-read" value="view blacklist" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="blacklist-read"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('manage blacklist'))
                                                            <input type="checkbox" class="custom-control-input" id="blacklist-write" value="manage blacklist" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="blacklist-write" value="manage blacklist" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="blacklist-write"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('create blacklist'))
                                                            <input type="checkbox" class="custom-control-input" id="blacklist-create" value="create blacklist" name="permissions[]" @cannot('manage users') disabled @endcannot checked>   
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="blacklist-create" value="create blacklist" name="permissions[]" @cannot('manage users') disabled @endcannot>   
                                                            <label class="custom-control-label" for="blacklist-create"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            @if($user->hasPermissionTo('delete blacklist'))
                                                            <input type="checkbox" class="custom-control-input" id="blacklist-delete" value="delete blacklist" name="permissions[]" @cannot('manage users') disabled @endcannot checked>
                                                            @endif
                                                            <input type="checkbox" class="custom-control-input" id="blacklist-delete" value="delete blacklist" name="permissions[]" @cannot('manage users') disabled @endcannot>
                                                            <label class="custom-control-label" for="blacklist-delete"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                        <!-- users edit account form ends -->
                    </div>
                    <!-- Account Tab ends -->

                    <!-- Information Tab starts -->
                    <div class="tab-pane" id="security" aria-labelledby="security-tab" role="tabpanel">
                        <!-- users edit Info form start -->
                        <form class="form-validate" method="POST" id="password-form" action="{{route('change-password', $user->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="row mt-1">
                                <div class="col-12">
                                    <h4 class="mb-1">
                                        <i data-feather="lock" class="font-medium-4 mr-25"></i>
                                        <span class="align-middle">Security</span>
                                    </h4>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="old-password">Old Password</label>
                                        <input id="old-password" type="password" class="form-control" name="old-password" placeholder="●●●●●●●●" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="new-password">New Password</label>
                                        <input id="new-password" type="password" class="form-control" name="password" placeholder="●●●●●●●●" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="confirm-password">New Password</label>
                                        <input id="confirm-password" type="password" class="form-control" name="password_confirmation" placeholder="●●●●●●●●" />
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" form="password-form" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                        <!-- users edit Info form ends -->
                    </div>
                    <!-- Information Tab ends -->

                    <!-- Social Tab starts -->
                    {{-- <div class="tab-pane" id="social" aria-labelledby="social-tab" role="tabpanel">
                        <!-- users edit social form start -->
                        <form class="form-validate">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 form-group">
                                    <label for="twitter-input">Twitter</label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">
                                                <i data-feather="twitter" class="font-medium-2"></i>
                                            </span>
                                        </div>
                                        <input id="twitter-input" type="text" class="form-control" value="https://www.twitter.com/adoptionism744" placeholder="https://www.twitter.com/" aria-describedby="basic-addon3" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 form-group">
                                    <label for="facebook-input">Facebook</label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon4">
                                                <i data-feather="facebook" class="font-medium-2"></i>
                                            </span>
                                        </div>
                                        <input id="facebook-input" type="text" class="form-control" value="https://www.facebook.com/adoptionism664" placeholder="https://www.facebook.com/" aria-describedby="basic-addon4" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 form-group">
                                    <label for="instagram-input">Instagram</label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">
                                                <i data-feather="instagram" class="font-medium-2"></i>
                                            </span>
                                        </div>
                                        <input id="instagram-input" type="text" class="form-control" value="https://www.instagram.com/adopt-ionism744" placeholder="https://www.instagram.com/" aria-describedby="basic-addon5" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 form-group">
                                    <label for="github-input">Github</label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon9">
                                                <i data-feather="github" class="font-medium-2"></i>
                                            </span>
                                        </div>
                                        <input id="github-input" type="text" class="form-control" value="https://www.github.com/madop818" placeholder="https://www.github.com/" aria-describedby="basic-addon9" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 form-group">
                                    <label for="codepen-input">Codepen</label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon12">
                                                <i data-feather="codepen" class="font-medium-2"></i>
                                            </span>
                                        </div>
                                        <input id="codepen-input" type="text" class="form-control" value="https://www.codepen.com/adoptism243" placeholder="https://www.codepen.com/" aria-describedby="basic-addon12" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 form-group">
                                    <label for="slack-input">Slack</label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon11">
                                                <i data-feather="slack" class="font-medium-2"></i>
                                            </span>
                                        </div>
                                        <input id="slack-input" type="text" class="form-control" value="@adoptionism744" placeholder="https://www.slack.com/" aria-describedby="basic-addon11" />
                                    </div>
                                </div>

                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                        <!-- users edit social form ends -->
                    </div> --}}
                    <!-- Social Tab ends -->
                </div>
            </div>
        </div>
    </section>
    <!-- users edit ends -->
@endsection

@section('vendor-js')
    @parent
    <script src="{{ asset ('/app-assets/vendors/js/forms/select/select2.full.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}" defer></script>
@endsection

@section('page-js')
    <script src="{{ asset ('/js/user-edit.js') }}" defer></script>
    @include('partials.form-response')
@endsection