@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-invoice.css') }}">
@endsection

@section('content')
    <section class="invoice-preview-wrapper">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12">
                <div class="card invoice-preview-card">
                    <div class="card-body invoice-padding pb-0">
                        <!-- Header starts -->
                        <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                            <div>
                                <div class="logo-wrapper">
                                    <img src="{{asset('/app-assets/images/logo/logo.png')}}" class="img-fluid logo-img" alt="Horeca Apartments">
                                    <h3 class="text-primary invoice-logo">{{ config('app.name', 'Laravel') }}</h3>
                                </div>
                                <p class="card-text mb-25">{{$reservation->apartments->address}}</p>
                                <p class="card-text mb-25">{{$reservation->apartments->country}}</p>
                                {{-- <p class="card-text mb-0">09035217974</p> --}}
                            </div>
                            <div class="mt-md-0 mt-2">
                                <h4 class="invoice-title">
                                    Reservation
                                    <span class="invoice-number">#{{$reservation->reference}}</span>
                                </h4>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Date Issued:</p>
                                    <p class="invoice-date">{{date('d/m/Y', strtotime($reservation->created_at))}}</p>
                                </div>
                                {{-- <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Due Date:</p>
                                    <p class="invoice-date">29/08/2020</p>
                                </div> --}}
                            </div>
                        </div>
                        <!-- Header ends -->
                    </div>

                    <hr class="invoice-spacing" />

                    <!-- Address and Contact starts -->
                    <div class="card-body invoice-padding pt-0">
                        <div class="row invoice-spacing">
                            <div class="col-xl-8 p-0">
                                <h6 class="mb-2">Guest:</h6>
                                <h6 class="mb-25">{{$reservation->guest->name}}</h6>
                                <p class="card-text mb-25">{{$reservation->guest->address}}</p>
                                <p class="card-text mb-25">{{$reservation->guest->country}}</p>
                                <p class="card-text mb-25">{{$reservation->guest->phone}}</p>
                                <p class="card-text mb-0">{{$reservation->guest->email}}</p>
                            </div>
                            <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                <h6 class="mb-2">Reservation Details:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pr-1">Arrival:</td>
                                            <td>{{$reservation->checkin}}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-1">Departure:</td>
                                            <td>{{$reservation->checkout}}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-1">Payment Method:</td>
                                            <td>{{$reservation->reservationPayments[0]->payment_method}}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-1">Payment Type:</td>
                                            <td class="text-capitalize">{{$reservation->reservationPayments[0]->payment_status}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Address and Contact ends -->

                    <!-- Invoice Description starts -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="py-1">Description</th>
                                    <th class="py-1">Rate</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="py-1">
                                        <p class="card-text font-weight-bold mb-25">{{$reservation->apartments->name}} ({{$reservation->nights}}) Night(s)</p>
                                        <p class="card-text text-nowrap">
                                            <span class="text-capitalize">{{$reservation->reservationPayments[0]->payment_status}}</span> payment for {{$reservation->apartments->name}}
                                        </p>
                                    </td>
                                    <td class="py-1">
                                        <span class="font-weight-bold">₦{{number_format($reservation->rate->amount,2)}}</span>
                                    </td>
                                    
                                    <td class="py-1">
                                        <span class="font-weight-bold">₦{{number_format($reservation->rate->amount * $reservation->nights,2)}}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body invoice-padding pb-0">
                        <div class="row invoice-sales-total-wrapper">
                            <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                <p class="card-text mb-0">
                                    <span class="font-weight-bold">Reserved By:</span> <span class="ml-75">{{$reservation->staff->name}}</span>
                                </p>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                <div class="invoice-total-wrapper">
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Subtotal:</p>
                                        <p class="invoice-total-amount">₦{{number_format($reservation->reservationPayments[0]->total, 2)}}</p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Discount:</p>
                                        <p class="invoice-total-amount">₦{{number_format($reservation->reservationPayments[0]->discount_amount, 2)}}</p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Tax:</p>
                                        <p class="invoice-total-amount">7.5%</p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Paid:</p>
                                        <p class="invoice-total-amount">₦{{number_format($reservation->reservationPayments[0]->paid, 2)}}</p>
                                    </div>
                                    <hr class="my-50" />
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Total Due:</p>
                                        <p class="invoice-total-amount">₦{{number_format($reservation->reservationPayments[0]->balance, 2)}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Description ends -->

                    <hr class="invoice-spacing" />

                    <!-- Invoice Note starts -->
                    <div class="card-body invoice-padding pt-0">
                        <div class="row">
                            <div class="col-12">
                                <span class="font-weight-bold">Note:</span>
                                <span>{{$reservation->extras}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Note ends -->
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary btn-block mb-75" data-toggle="modal" data-target="#send-invoice-sidebar">
                            Send Invoice
                        </button>
                        <a href="/print-invoice/{{$reservation->reference}}" class="btn btn-outline-secondary btn-block btn-download-invoice mb-75">Download</a>
                        <a class="btn btn-outline-secondary btn-block mb-75" href="/print-invoice/{{$reservation->reference}}" target="_blank">
                            Print
                        </a>
                        <a class="btn btn-outline-secondary btn-block mb-75" data-toggle="modal" data-target="#edit-guest-sidebar"> Edit Guest</a>
                        <form action="{{route('checkin-guest', $reservation->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="reservation" value="{{$reservation->id}}">
                            <button class="btn btn-success btn-block" type="submit">
                                Checkin
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
    </section>
    <!-- Edit Guest Sidebar -->
    <div class="modal modal-slide-in fade" id="edit-guest-sidebar" aria-hidden="true">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">
                        <span class="align-middle">Send Invoice</span>
                    </h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <form method="POST" action="{{route('edit-guest', $reservation->guest->id)}}">
                        @csrf
                        <input type="hidden" name="reservation" value="{{$reservation->id}}">
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" value="{{$reservation->guest->title}}" name="title" />
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="{{$reservation->guest->name}}" name="name"/>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{$reservation->guest->email}}" name="email" />
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="phone" class="form-control" id="phone" value="{{$reservation->guest->phone}}" name="phone" />
                        </div>
                        <div class="form-group">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" value="{{$reservation->guest->address}}" name="address" />
                        </div>
                        <div class="form-group">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" value="{{$reservation->guest->country}}" name="country" />
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
    <!-- /Edit Guest Sidebar -->
@endsection

@section('vendor-js')
    @parent
    <script src="{{ asset ('/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}" defer></script>
@endsection

@section('page-js')
    @parent
    <script src="{{ asset ('/app-assets/js/scripts/pages/app-invoice.js') }}" defer></script>
    @include('partials.form-response')
@endsection