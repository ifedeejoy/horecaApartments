@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-invoice-list.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-user.css') }}">
@endsection

@section('content')
    <section class="app-user-view">
        <!-- User Card & Plan Starts -->
        <div class="row">
            <!-- User Card starts-->
            <div class="col-xl-9 col-lg-8 col-md-7">
                <div class="card user-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                <div class="user-avatar-section">
                                    <div class="d-flex justify-content-start">
                                        <img class="img-fluid rounded" src="{{ asset('/images/apartments.svg') }}" style="height: 124px; width: 104px" alt="User avatar" />
                                        <div class="d-flex flex-column ml-1">
                                            <div class="user-info mb-1">
                                                <h4 class="mb-0">{{$apartment->name}}</h4>
                                                <span class="card-text text-capitalize">{{$apartment->type}}</span>
                                            </div>
                                            <form class="d-flex flex-wrap" action="{{route('delete-apartment', $apartment->id)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a data-toggle="modal" data-target="#edit-apartment" class="btn btn-primary">Edit</a>
                                                <button type="submit" title="delete apartment" class="btn btn-outline-danger ml-1">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center user-total-numbers">
                                    <div class="d-flex align-items-center mr-2">
                                        @if ($apartment->status == 'available')
                                        <div class="color-box bg-light-success">
                                            <i data-feather="trending-up" class="text-success"></i>
                                        </div>
                                        @else
                                        <div class="color-box bg-light-danger">
                                            <i data-feather="trending-up" class="text-danger"></i>
                                        </div>
                                        @endif
                                        <div class="ml-1">
                                            <h5 class="mb-0 text-capitalize">{{$apartment->status}}</h5>
                                            <small>Availability Status</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        @if (is_null($apartment->maintenance_status))
                                        <div class="color-box bg-light-success">
                                            <i class="lni lni-warning" class="text-success"></i>
                                        </div>
                                        @else
                                        <div class="color-box bg-light-danger">
                                            <i class="lni lni-warning" class="text-danger"></i>
                                        </div>
                                        @endif
                                        <div class="ml-1">
                                            <h5 class="mb-0">
                                                @if (is_null($apartment->maintenance_status))
                                                    No Issues
                                                @else
                                                    {{$apartment->maintenance_status}}
                                                @endif
                                            </h5>
                                            <small>Maintenance Status</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                <div class="user-info-wrapper">
                                    <div class="d-flex flex-wrap">
                                        <div class="user-info-title">
                                            <i data-feather="user" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Owner Name</span>
                                        </div>
                                        <p class="card-text mb-0 text-capitalize">{{$owner->name}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="check" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Status</span>
                                        </div>
                                        <p class="card-text mb-0 text-capitalize">{{$owner->status}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="star" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Role</span>
                                        </div>
                                        <p class="card-text mb-0 text-capitalize">{{$owner->type}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="mail" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Email</span>
                                        </div>
                                        <p class="card-text mb-0 text-capitalize">{{$owner->email}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="user-info-title">
                                            <i data-feather="phone" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Contact</span>
                                        </div>
                                        <p class="card-text mb-0 text-capitalize">{{$owner->phone}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card Ends-->

            <!-- Plan Card starts-->
            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="card plan-card border-primary">
                    <div class="card-header d-flex justify-content-between align-items-center pt-75 pb-1">
                        <h5 class="mb-0">Apartment Rates</h5>
                        <span class="badge badge-light-secondary" data-toggle="tooltip" data-placement="top" title="Expiry Date">{{date("Y-m-d")}}</span>
                        </span>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled my-1">
                        @foreach ($rates as $rate)
                        <li class="d-flex justify-content-between mb-2">
                            <span class="align-middle">{{$rate->name}}</span>
                            <div class="badge badge-light-primary">{{number_format($rate->amount)}}</div>
                        </li>
                        @endforeach
                        <button class="btn btn-primary text-center btn-block" data-toggle="modal" data-target="#edit-rate">Edit Rate</button>
                    </div>
                </div>
            </div>
            <!-- /Plan CardEnds -->
        </div>
        <!-- User Card & Plan Ends -->

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
                                    <th>Checkin</th>
                                    <th>Checkout</th>
                                    <th>Total</th>
                                    <th>Reserved On</th>
                                    <th class="cell-fit">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /User Invoice Ends-->

        <!-- Edit Apartment -->
        <div class="modal modal-slide-in fade" id="edit-apartment" aria-hidden="true">
            <div class="modal-dialog sidebar-lg">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">
                            <span class="align-middle">Edit Apartment</span>
                        </h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <form method="POST" action="{{route('edit-apartment', $apartment->id)}}">
                            @csrf
                            <div class="form-group">
                                <label for="aparment-name" class="form-label">Apartment Name</label>
                                <input type="text" class="form-control" name="apartment-name" id="aparment-name" value="{{$apartment->name}}" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="apartment-type">Apartment Type</label>
                                <select class="select2 w-100" id="apartment-type" name="apartment-type">
                                    <option value="{{$apartment->type}}" selected>{{$apartment->type}}</option>
                                    <option value="room">Room</option>
                                    <option value="apartment">Apartment</option>
                                    <option value="masionette">Masionette</option>
                                    <option value="studio">Studio</option>
                                    <option value="bungalow">Bungalow</option>
                                    <option value="camper">Camper</option>
                                    <option value="villa">Villa</option>
                                    <option value="tent">Tent</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="apartment-description" class="form-label">Description</label>
                                <textarea class="form-control" name="apartment-description" id="apartment-description" cols="3" rows="9" placeholder="Apartment Description">
                                    {{$apartment->description}}
                                </textarea>
                            </div>
                            <div class="input-group w-100">
                                <label class="form-label" for="max-guests">Max Guests(s)</label>
                                <input type="text" id="max-guests" name="max-guests" class="touchspin input-control-lg" value="{{$apartment->max_guests}}" />
                            </div>
                            <div class="input-group w-100 mt-2">
                                <label class="form-label" for="beds">Bed(s)</label>
                                <input type="text" id="beds" name="beds" class="touchspin input-control-lg" value="{{$apartment->beds}}" />
                            </div>
                            <hr class="my-1 mt-2">
                            <div class="form-group">
                                <label class="form-label" for="apartment-owner">Apartment Owner</label>
                                <select class="select2 w-100" id="apartment-owner" name="apartment-owner">
                                    <option value="{{$owner->id}}" selected>{{$owner->name}}</option>
                                    @foreach ($owners as $owner)
                                    <option value="{{$owner->id}}">{{$owner->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="apartment-address">Address</label>
                                <input type="text" id="apartment-address" name="apartment-address" class="form-control" value="{{$apartment->adress}}" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="apartment-country">Country</label>
                                <select class="select2 w-100" id="apartment-country" name="apartment-country">
                                    <option value="{{$apartment->country}}" selected>{{$apartment->country}}</option>
                                    @include('partials.country-options')
                                </select>
                            </div>
                            <div class="form-group d-flex flex-wrap mt-2">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Apartment Ends -->
        <!-- Edit Rate -->
        <div class="modal modal-slide-in fade" id="edit-rate" aria-hidden="true">
            <div class="modal-dialog sidebar-lg">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">
                            <span class="align-middle">Edit Rate</span>
                        </h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <form method="POST" action="{{route('edit-rate')}}">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label" for="rate">Rate</label>
                                <select class="select2 w-100" id="rate" name="rate">
                                    <option label=" "></option>
                                    @foreach ($rates as $rate)
                                    <option value="{{$rate->id}}">{{$rate->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group w-100 mb-3">
                                <label class="form-label" for="rate-price">Rate Price</label>
                                <input type="text" id="rate-price" name="rate-price" class="touchspin input-control-lg" value="{number}" />
                            </div>
                            <div class="form-group d-flex flex-wrap mt-2">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Rate Ends -->
    </section>
@endsection
           
@section('vendor-js')
    @parent
    <script src="{{ asset ('/app-assets/vendors/js/extensions/moment.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/forms/select/select2.full.min.js') }}" defer></script>
@endsection

@section('page-js')
    @parent
    <script src="{{ asset ('/app-assets/js/scripts/pages/app-apartment-view.js') }}" defer></script>
    <script type="module" defer>
        $('.touchspin').TouchSpin({
            buttondown_class: 'btn btn-primary',
            buttonup_class: 'btn btn-primary',
            buttondown_txt: feather.icons['minus'].toSvg(),
            buttonup_txt: feather.icons['plus'].toSvg(),
            max: 10000000000
        });
        $("#apartment-owner").select2();
        $("#apartment-type").select2();
        $("#apartment-country").select2();
        $("#rate").select2({
            placeholder: 'Select Rate'
        });
    </script>
    @include('partials.form-response')
@endsection
