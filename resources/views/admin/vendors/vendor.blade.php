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
                                        <img class="img-fluid rounded" src="{{asset('/images/user.svg')}}" style="width: 100px; height: 100px" alt="User avatar" />
                                        <div class="d-flex flex-column ml-1">
                                            <div class="user-info mb-1">
                                                <h4 class="mb-0">{{$vendor->name}}</h4>
                                                <span class="card-text">{{$vendor->phone}}</span>
                                            </div>
                                            <form class="d-flex flex-wrap" action="{{route('delete-user', $vendor->id)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="/admin/edit-phone/{{$vendor->id}}" class="btn btn-primary">Edit</a>
                                                <button type="submit" title="delete phone" class="btn btn-outline-danger ml-1">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center user-total-numbers">
                                    <div class="d-flex align-items-center mr-2">
                                        <div class="color-box bg-light-primary d-flex align-items-center">
                                            <h4 class="text-primary p-1">₦</h4>
                                        </div>
                                        <div class="ml-1">
                                            <h5 class="mb-0">{{readableNumber($payments->sum('paid'))}}</h5>
                                            <small>Total Paid</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="color-box bg-light-success">
                                            <i data-feather="trending-up" class="text-success"></i>
                                        </div>
                                        <div class="ml-1">
                                            <h5 class="mb-0">{{count($purchases??[]) + count($issues??[])}}</h5>
                                            <small>Tasks/Purchases</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-12 mt-2 mt-xl-0 d-flex justify-content-start">
                                <div class="user-info-wrapper">
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="check" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Business Name</span>
                                        </div>
                                        <p class="card-text mb-0">{{$vendor->business_name}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="check" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Email</span>
                                        </div>
                                        <p class="card-text mb-0">{{$vendor->email}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="star" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Department</span>
                                        </div>
                                        <p class="card-text mb-0">{{$vendor->type}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="flag" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Address</span>
                                        </div>
                                        <p class="card-text mb-0">{{$vendor->address}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="user-info-title">
                                            <i data-feather="phone" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Contact</span>
                                        </div>
                                        <p class="card-text mb-0">{{$vendor->phone}}</p>
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

        @if ($vendor->type == 'maintenance' || $vendor->type == 'all')
        <!-- Vendor Maintenance Tasks Starts-->
        <div class="row invoice-list-wrapper">
            <div class="col-12">
                <div class="card p-1">
                    <div class="card-header">
                        <h5 class="card-title">Maintenance Tasks</h5>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="maintenance-list-table text-center table" id="maintenance-list-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Apartment</th>
                                    <th>Issue</th>
                                    <th>Status</th>
                                    <th>Images</th>
                                    <th>Reported</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($issues))
                                @foreach ($issues as $issue)
                                <tr>
                                    <td>{{$issue->id}}</td>
                                    <td>{{$issue->apartment->name}}</td>
                                    <td>{!! $issue->issue !!}</td>
                                    <td class="text-capitalize"> 
                                    @if ($issue->status == 'reported')
                                        <span class="badge badge-pill badge-light-warning" text-capitalized>{{$issue->status}}</span>
                                    @elseif($issue->status == 'assigned')
                                        <span class="badge badge-pill badge-light-info" text-capitalized>{{$issue->status}}</span>
                                    @elseif($issue->status == 'ongoing')
                                        <span class="badge badge-pill badge-light-secondary" text-capitalized>{{$issue->status}}</span>
                                    @elseif($issue->status == 'completed')
                                        <span class="badge badge-pill badge-light-success" text-capitalized>{{$issue->status}}</span>
                                    @elseif($issue->status == 'failed')
                                        <span class="badge badge-pill badge-light-danger" text-capitalized>{{$issue->status}}</span>
                                    @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-around flex-wrap">
                                            @if (!empty($issue->images))
                                                @foreach (json_decode($issue->images) as $image)
                                                <a href="{{$image}}" data-lightbox="image-{{$loop->iteration}}" data-title="{{$issue->issue}}">
                                                    <img src="{{$image}}" alt="{{$issue->issue}}" class="img-fluid maintenance-thumbnail">
                                                </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                    <td data-sort="{{strtotime($issue->created_at)}}">{{\Carbon\Carbon::parse($issue->created_at)->diffForHumans()}}</td>
                                </tr> 
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Vendor Maintenance Tasks Ends--> 
        @endif
        
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
