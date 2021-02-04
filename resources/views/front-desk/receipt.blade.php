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
                                            <td>{{date('d/m/Y H:i', strtotime($reservation->checkin))}}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-1">Departure:</td>
                                            <td>{{date('d/m/Y H:i', strtotime($reservation->checkout))}}</td>
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
                                @foreach ($reservation->guestBill as $bill)
                                <tr class="border-bottom">
                                    <td class="py-1">
                                        <p class="card-text font-weight-bold mb-25">{{$bill->service}} ({{$bill->status}})</p>
                                        <p class="card-text text-nowrap mb-25">
                                            <span class="text-capitalize">{{$bill->description}}
                                        </p>
                                        <p class="card-text text-nowrap">
                                           <span class="font-weight-bold">Posted:</span> {{date("d/m/Y", strtotime($bill->created_at))}}
                                        </p>
                                    </td>
                                    <td class="py-1">
                                        <span class="font-weight-bold"></span>
                                    </td>
                                    
                                    <td class="py-1">
                                        <span class="font-weight-bold">₦{{number_format($bill->price,2)}}</span>
                                    </td>
                                </tr>
                                @endforeach
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
                                        <p class="invoice-total-title">Extras:</p>
                                        <p class="invoice-total-amount">₦{{number_format(multiSum($reservation->guestBill, 'price'), 2) }}</p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Discount:</p>
                                        <p class="invoice-total-amount">₦{{number_format($reservation->reservationPayments[0]->discount_amount, 2)}}</p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Total:</p>
                                        <p class="invoice-total-amount">₦{{number_format($reservation->reservationPayments[0]->total + multiSum($reservation->guestBill, 'price'), 2)}}</p>
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
            <div class="col-xl-3 col-md-4 col-12 d-flex flex-column">
                <div class="invoice-actions mt-md-0 mt-2 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <a class="btn btn-primary btn-block mb-1" href="/print-invoice/{{$reservation->reference}}" target="_blank">
                                Print
                            </a>       
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- /Invoice Actions -->
        </div>
    </section>


@endsection

@section('vendor-js')
    @parent
    <script src="{{ asset ('/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}" defer></script>
@endsection

@section('page-js')
    @parent
    <script src="{{ asset ('/app-assets/js/scripts/pages/app-invoice.js') }}" defer></script>
    <script src="{{ asset ('/js/core.js') }}" defer></script>
    <script type="module" defer>
        $('#new-checkout').flatpickr({
            enableTime: true,
        });
    </script>
    @include('partials.form-response')
@endsection