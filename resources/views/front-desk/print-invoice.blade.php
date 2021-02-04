@extends('layouts.app')

@section('vendor-css')
@parent
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-invoice-print.css') }}">
@endsection


<!-- BEGIN: Body-->

@section('content')
    <div class="invoice-print p-3">
        <div class="d-flex justify-content-between flex-md-row flex-column pb-2">
            <div>
                <div class="d-flex mb-1">
                    <div class="logo-wrapper">
                        <img src="{{asset ('/app-assets/images/logo/logo.png')}}" class="img-fluid logo-img" alt="Horeca Apartments">
                        <h3 class="text-primary invoice-logo">{{ config('app.name', 'Laravel') }}</h3>
                    </div>
                </div>
                <p class="mb-25">{{$reservations[0]->apartments->address}}</p>
                <p class="mb-25">{{$reservations[0]->apartments->country}}</p>
                {{-- <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p> --}}
            </div>
            <div class="mt-md-0 mt-2">
                <h4 class="font-weight-bold text-right mb-1">INVOICE #{{$reservations[0]->reference}}</h4>
                <div class="invoice-date-wrapper mb-50">
                    <span class="invoice-date-title">Date Issued:</span>
                    <span class="font-weight-bold"> {{date('d/m/Y', strtotime($reservations[0]->created_at))}}</span>
                </div>
            </div>
        </div>

        <hr class="my-2" />

        <div class="row pb-2">
            <div class="col-sm-6">
                <h6 class="mb-1">Invoice To:</h6>
                <p class="mb-25">{{$reservations[0]->guest->name}}</p>
                <p class="mb-25">{{$reservations[0]->guest->address}}</p>
                <p class="mb-25">{{$reservations[0]->guest->country}}</p>
                <p class="mb-25">{{$reservations[0]->guest->phone}}</p>
                <p class="mb-0">{{$reservations[0]->guest->email}}</p>
            </div>
            <div class="col-sm-6 mt-sm-0 mt-2">
                <h6 class="mb-1">Payment Details:</h6>
                <table>
                    <tbody>
                        <tr>
                            <td class="pr-1">Arrival:</td>
                            <td>{{$reservations[0]->checkin}}</td>
                        </tr>
                        <tr>
                            <td class="pr-1">Departure:</td>
                            <td>{{$reservations[0]->checkout}}</td>
                        </tr>
                        <tr>
                            <td class="pr-1">Payment Method:</td>
                            <td>{{$reservations[0]->reservationPayments[0]->payment_method}}</td>
                        </tr>
                        <tr>
                            <td class="pr-1">Payment Type:</td>
                            <td class="text-capitalize">{{$reservations[0]->reservationPayments[0]->payment_status}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-responsive mt-2">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th class="py-1">Description</th>
                        <th class="py-1">Rate</th>
                        <th class="py-1">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                    <tr class="border-bottom">
                        <td class="py-1 pl-4">
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
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row invoice-sales-total-wrapper mt-3">
            <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                <p class="card-text mb-0">
                    <span class="font-weight-bold">Salesperson:</span> <span class="ml-75">{{$reservation->staff->name}}</span>
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                <div class="invoice-total-wrapper">
                    <div class="invoice-total-item">
                        <p class="invoice-total-title">Subtotal:</p>
                        <p class="invoice-total-amount">₦{{number_format($reservations[0]->reservationPayments[0]->total, 2)}}</p>
                    </div>
                    <div class="invoice-total-item">
                        <p class="invoice-total-title">Discount:</p>
                        <p class="invoice-total-amount">₦{{number_format($reservations[0]->reservationPayments[0]->discount_amount, 2)}}</p>
                    </div>
                    <div class="invoice-total-item">
                        <p class="invoice-total-title">Tax:</p>
                        <p class="invoice-total-amount">7.5%</p>
                    </div>
                    <div class="invoice-total-item">
                        <p class="invoice-total-title">Paid:</p>
                        <p class="invoice-total-amount">₦{{number_format($reservations[0]->reservationPayments[0]->paid, 2)}}</p>
                    </div>
                    <hr class="my-50" />
                    <div class="invoice-total-item">
                        <p class="invoice-total-title">Total Due:</p>
                        <p class="invoice-total-amount">₦{{number_format($reservations[0]->reservationPayments[0]->balance, 2)}}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-2" />

        <div class="row">
            <div class="col-12">
                <span class="font-weight-bold">Note:</span>
                <span>{{$reservations[0]->extras}}</span>
            </div>
        </div>
    </div>
@endsection

@section('vendor-js')
    @parent
@endsection

@section('page-js')
    @parent
    <script src="{{ asset ('/app-assets/js/scripts/pages/app-invoice-print.js') }}" defer></script>
@endsection