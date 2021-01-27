@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ secure_asset ('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset ('app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset ('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset ('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ secure_asset ('app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet" href="{{ secure_asset ('app-assets/css/plugins/forms/form-wizard.css') }}">
<link rel="stylesheet" href="{{ secure_asset ('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" href="{{ secure_asset ('app-assets/css/plugins/forms/form-file-uploader.css') }}">
@endsection

@section('content-header')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h2 class="content-header-title float-left mb-0" data-i18n="New Reservation">New Reservation</h2>
            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/front-desk/reservations" data-i18n="Reservations">Reservations</a>
                    </li>
                    <li class="breadcrumb-item active" data-i18n="New Reservation">New Reservation
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="vertical-wizard">
    <div class="bs-stepper vertical vertical-wizard-example">
        <div class="bs-stepper-header">
            
            <div class="step mb-1" data-target="#personal-info-vertical">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">1</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Personal Info</span>
                        <span class="bs-stepper-subtitle">Add Personal Info</span>
                    </span>
                </button>
            </div>
            <div class="step mb-1" data-target="#stay-details-vertical">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">2</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Reservation Details</span>
                        <span class="bs-stepper-subtitle">Add Reservation Details</span>
                    </span>
                </button>
            </div>
            <div class="step mb-1" data-target="#other-info-vertical">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">3</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Other Information</span>
                        <span class="bs-stepper-subtitle">Add Extra Info</span>
                    </span>
                </button>
            </div>
            <div class="step mb-1" data-target="#billing-info-vertical">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">4</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Billing Information</span>
                        <span class="bs-stepper-subtitle">Add Billing Information</span>
                    </span>
                </button>
            </div>
        </div>
        <div class="bs-stepper-content">
            <div id="personal-info-vertical" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Personal Info</h5>
                    <small>Enter Your Personal Info.</small>
                </div>
                <hr class="my-1">
                <div class="row mb-2">
                    <div class="form-group col-md-3">
                        <label class="form-label" for="title">Title</label>
                        <select class="select2 w-100" id="title">
                            <option label=" "></option>
                            <option>Mr</option>
                            <option>Mrs</option>
                            <option>Miss</option>
                            <option>Ms</option>
                            <option>Dr</option>
                            <option>Professor</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="first-name">First Name</label>
                        <input type="text" id="first-name" class="form-control" placeholder="John" />
                    </div>
                    <div class="form-group col-md-5">
                        <label class="form-label" for="last-name">Last Name</label>
                        <input type="text" id="last-name" class="form-control" placeholder="Doe" />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="phone-number">Phone</label>
                        <input type="text" id="phone-number" class="form-control" placeholder="+234-903-292-9991" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" id="address" class="form-control" placeholder="98  Borough bridge Road, Birmingham" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="country">Country</label>
                        <select class="select2 w-100" id="country">
                            <option label=" "></option>
                            @include('partials.country-options')
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-outline-secondary btn-prev" disabled>
                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-next">
                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                    </button>
                </div>
            </div>
            <div id="stay-details-vertical" class="content">
                <div class="content-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">Reservation Details</h5>
                            <small class="text-muted">Enter Reservation Details.</small>
                        </div>
                        <button class="btn-icon btn btn-primary btn-round btn-sm" type="button" onclick="addRooms()">
                            <i data-feather="plus"></i>
                            <i data-feather="home"></i>
                        </button>
                    </div>
                </div>
                <hr class="my-1">

                <div id="rooms-section">
                    <div class="rooms">
                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="room-category">Apartment</label>
                                <select class="select2 w-100" id="room-category">
                                    <option label=" "></option>
                                    <option>Abeke's Court</option>
                                    <option>Alex's Maisonette</option>
                                    <option>Ebony Apartment</option>
                                    <option>Maxwell's Court</option>
                                    <option>Ijora Olopa</option>
                                    <option>Sola Aparment</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="arrival">Arrival Date/Time</label>
                                <input type="text" id="arrival" class="form-control" placeholder="13-12-2020 2:00 PM" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="room-rate">Rate</label>
                                <select class="select2 w-100" id="room-rate">
                                    <option label=" "></option>
                                    <option>Rack</option>
                                    <option>Weekend</option>
                                    <option>Bed & Breakfast</option>
                                </select>
                            </div>
                            <div class="input-group col-md-6">
                                <label class="form-label" for="nights">Night(s)</label>
                                <input type="text" id="nights" class="touchspin input-group-lg" value="{number}" />
                            </div>
                        </div>
        
                        <div class="row mb-2">
                            <div class="input-group col-md-6">
                                <label class="form-label" for="occupants">Occupant(s)</label>
                                <input type="text" id="occupants" class="touchspin input-group-lg" value="{number}" />
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group mb-0">
                                    <textarea data-length="200" class="form-control char-textarea" id="notes" rows="2" placeholder="Additional information"></textarea>
                                    <label for="notes">Notes</label>
                                </div>
                                <small class="textarea-counter-value float-right"><span class="char-count">0</span> / 200 </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-primary btn-prev">
                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-next">
                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                    </button>
                </div>
            </div>
            <div id="other-info-vertical" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Other Information</h5>
                    <small>Enter Other Information.</small>
                </div>
                <hr class="my-1">
                <div class="row mb-2">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="reservation-source">Reservation Source</label>
                        <select class="select2 w-100" id="reservation-source">
                            <option label=" "></option>
                            <option>Airbnb</option>
                            <option>Booking.com</option>
                            <option>Expedia</option>
                            <option>Hotels.ng</option>
                            <option>Walk-In Guest</option>
                            <option>Mr Wasiu Agent</option>
                            <option>Mr Jamiu Agent</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="id-type">Identification Type</label>
                        <select class="select2 w-100" id="id-type">
                            <option label=" "></option>
                            <option>National Id</option>
                            <option>Drivers License</option>
                            <option>Internatinal Passport</option>
                            <option>Voters Card</option>
                            <option>Company ID</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="form-group col-md-6">
                        <div class="dropzone dropzone-area guest-id-field" id="guest-id">
                            <div class="dz-message guest-id-text">Drop files here or click to upload guest ID.</div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="gender">Gender</label>
                        <select class="select2 w-100" id="gender">
                            <option label=" "></option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Others</option>
                            <option>Prefer not to say</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-primary btn-prev">
                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-next">
                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                    </button>
                </div>
            </div>
            <div id="billing-info-vertical" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Billing Information</h5>
                    <small>Enter Reservation Payment Information.</small>
                </div>
                <div class="row" id="ip-container">
                    <div class="form-group col-md-6 mb-2">
                        <label class="form-label" for="payment-status">Payment Status</label>
                        <select class="select2 w-100" id="payment-status" name="payment-status" onchange="togglePayment(this.value)">
                            <option label=" "></option>
                            <option value="no payment">No Payment</option>
                            <option value="partial payment">Partial Payment</option>
                            <option value="full payment">Full Payment</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-2 d-none" id="pm-container">
                        <label class="form-label" for="payment-method">Payment Method</label>
                        <select class="select2 w-100" id="payment-method">
                            <option label=" "></option>
                            <option>Bank Transfer</option>
                            <option>Cash</option>
                            <option>Credit</option>
                            <option>Cryptocurrency</option>
                            <option>POS</option>
                            <option>Post Master</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label class="form-label" for="service-charge">Service Charge</label>
                        <select class="select2 w-100" id="service-charge">
                            <option label=" "></option>
                            <option>No</option>
                            <option>Yes</option>
                        </select>
                    </div>
                </div>

                {{-- Discount Section --}}
                <div class="row mb-2 d-none" id="gd-container">
                    <div class="form-group col-md-4 mb-2">
                        <label class="form-label" for="give-discount" name="give-discount" onchange="toggleDiscount(this.value)">Give Discount</label>
                        <select class="select2 w-100" id="give-discount">
                            <option label=" "></option>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="discount">Discount (₦)</label>
                        <input type="text" id="discount" class="form-control" placeholder="100,000" />
                    </div>
                    <div class="col-md-4">
                        <div class="form-label-group mb-0">
                            <textarea data-length="200" class="form-control char-textarea" id="discount-reason" rows="3" placeholder="Reason for giving discount to guest"></textarea>
                            <label for="discount-reason">Discount Reason</label>
                        </div>
                        <small class="textarea-counter-value float-right"><span class="char-count">0</span> / 200 </small>
                    </div>
                </div>

                {{-- Deposit Section --}}
                <div class="row mb-2 d-none" id="dp-container">
                    <div class="form-group col-md-6 mb-2">
                        <label class="form-label" for="down-payment" name="down-payment" onchange="toggleDeposit(this.value)">Down Payment</label>
                        <select class="select2 w-100" id="down-payment">
                            <option label=" "></option>
                            <option value="no">No</option>
                            <option value="no">Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6"> 
                        <label class="form-label" for="deposit">Deposit (₦)</label>
                        <input type="text" id="deposit" class="form-control" placeholder="100,000" />
                    </div>
                </div>

                {{-- Total Section --}}
                <div class="row mb-2">
                    <div class="form-group col-md-4">
                        <label class="form-label" for="subtotal">Subtotal (₦)</label>
                        <input type="text" id="subtotal" class="form-control" placeholder="100,000" readonly/>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="balance">Balance (₦)</label>
                        <input type="text" id="balance" class="form-control" placeholder="100,000"  readonly/>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="total">Total (₦)</label>
                        <input type="text" id="total" class="form-control" placeholder="100,000" readonly/>
                    </div>
                </div>

                {{-- Submit Section --}}
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-primary btn-prev">
                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-success btn-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-js')
    @parent
    <script src="{{ secure_asset ('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}" defer></script>
    <script src="{{ secure_asset ('app-assets/vendors/js/forms/select/select2.full.min.js') }}" defer></script>
    <script src="{{ secure_asset ('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}" defer></script>
    <script src="{{ secure_asset ('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}" defer></script>
    <script src="{{ secure_asset ('app-assets/vendors/js/extensions/dropzone.min.js') }}" defer></script>
@endsection

@section('page-js')
    @parent
    <script src="{{ secure_asset ('js/scripts.js') }}" defer></script>
    <script src="{{ secure_asset ('app-assets/js/scripts/forms/form-wizard.js') }}" defer></script>
    <script src="{{ secure_asset ('app-assets/js/scripts/forms/form-number-input.js') }}" defer></script>
    <script src="{{ secure_asset ('app-assets/js/scripts/forms/form-file-uploader.js') }}" defer></script>
@endsection