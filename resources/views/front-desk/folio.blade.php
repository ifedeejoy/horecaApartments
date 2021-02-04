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
                                    <h3 class="text-primary invoice-logo">Kimberly's Apartments</h3>
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
                            <button class="btn btn-outline-warning btn-block mb-1" data-toggle="modal" data-target="#add-bill-sidebar">
                                Add Bill
                            </button>
                            <button class="btn btn-outline-success btn-block mb-1" data-toggle="modal" data-target="#extend-stay-sidebar">
                                Extend Guest Stay
                             </button>    
                             <button class="btn bg-outline-pink btn-block mb-1" data-toggle="modal" data-target="#send-invoice-sidebar">
                                 Apartment Move
                            </button>  
                            @if ($reservation->reservationPayments[0]->balance > 0)
                            <button class="btn btn-outline-success btn-block mb-1" data-toggle="modal" data-target="#add-payment-sidebar">
                                Add Payment
                            </button>
                               
                            <form action="{{route('checkout', $reservation->id)}}" method="post" id="checkout-debt">
                                @csrf
                                <input type="hidden" name="type" value="debt">
                                <button class="btn btn-danger btn-block" type="submit" form="checkout-debt">
                                    Checkout With Debt
                                </button>
                            </form>
                            @elseif($reservation->reservationPayments[0]->balance < 0)
                            <form action="{{route('checkout', $reservation->id)}}" method="post" id="checkout-postmaster">
                                @csrf
                                <input type="hidden" name="type" value="postmaster">
                                <button class="btn bg-outline-dark-blue btn-block mb-1" type="submit" form="checkout-postmaster">
                                    Add To Postmaster
                                </button>
                            </form>
                            <form action="{{route('checkout', $reservation->id)}}" method="post" id="checkout-refund">
                                @csrf
                                <input type="hidden" name="type" value="refund">
                                <button class="btn btn-success btn-block mb-1" type="submit" form="checkout-refund">
                                    Refund & Checkout
                                </button>
                            </form>
                            @else
                            <form action="{{route('checkout', $reservation->id)}}" method="post" id="checkout">
                                @csrf
                                <button class="btn btn-danger btn-block" type="submit" form="checkout">
                                    Checkout
                                </button>
                            </form>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- /Invoice Actions -->
        </div>
    </section>
    <!-- Send Invoice Sidebar -->
    <div class="modal modal-slide-in fade" id="send-invoice-sidebar" aria-hidden="true">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">
                        <span class="align-middle">Send Invoice</span>
                    </h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <form>
                        <div class="form-group">
                            <label for="invoice-from" class="form-label">From</label>
                            <input type="text" class="form-control" id="invoice-from" value="shelbyComapny@email.com" placeholder="company@email.com" />
                        </div>
                        <div class="form-group">
                            <label for="invoice-to" class="form-label">To</label>
                            <input type="text" class="form-control" id="invoice-to" value="qConsolidated@email.com" placeholder="company@email.com" />
                        </div>
                        <div class="form-group">
                            <label for="invoice-subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="invoice-subject" value="Invoice of purchased Admin Templates" placeholder="Invoice regarding goods" />
                        </div>
                        <div class="form-group">
                            <label for="invoice-message" class="form-label">Message</label>
                            <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="11" placeholder="Message...">
                                Dear Queen Consolidated,
                                
                                Thank you for your business, always a pleasure to work with you!
                                
                                We have generated a new invoice in the amount of $95.59
                                
                                We would appreciate payment of this invoice by 05/11/2019
                            </textarea>
                        </div>
                        <div class="form-group">
                            <span class="badge badge-light-primary">
                                <i data-feather="link" class="mr-25"></i>
                                <span class="align-middle">Invoice Attached</span>
                            </span>
                        </div>
                        <div class="form-group d-flex flex-wrap mt-2">
                            <button type="button" class="btn btn-primary mr-1" data-dismiss="modal">Send</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Send Invoice Sidebar -->

    <!-- Extend Stay Sidebar -->
    <div class="modal modal-slide-in fade" id="extend-stay-sidebar" aria-hidden="true">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">
                        <span class="align-middle">Extend Stay</span>
                    </h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <form action="{{route('extend-stay', $reservation->id)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="old-checkout">Old Checkout Date/Time</label>
                            <input type="text" id="old-checkout" name="old-checkout" class="form-control" value="{{$reservation->checkout}}" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="new-checkout">New Checkout Date/Time</label>
                            <input type="text" id="new-checkout" name="new-checkout" class="form-control" placeholder="13-12-2020 2:00 PM"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="discount">Discount on extension</label>
                            <input id="discount" class="form-control" type="number" inputmode="numeric" name="discount" placeholder="$1000" />
                        </div>
                        <div class="form-group d-flex flex-wrap mt-2">
                            <button type="submit" class="btn btn-primary mr-1">Send</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Extend Stay Sidebar -->

    <!-- Add Payment Sidebar -->
    <div class="modal modal-slide-in fade" id="add-payment-sidebar" aria-hidden="true">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">
                        <span class="align-middle">Add Payment</span>
                    </h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <form method="POST" action="{{route('add-guest-payment', $reservation->id)}}">
                        @csrf
                        <div class="form-group">
                            <input id="balance" class="form-control" type="text" value="Invoice Balance: {{$reservation->reservationPayments[0]->balance}}" disabled />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="amount">Payment Amount</label>
                            <input id="amount" class="form-control" type="number" inputmode="numeric" name="amount" placeholder="$1000" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="payment-date">Payment Date</label>
                            <input id="payment-date" class="form-control date-picker" type="text" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="payment-method">Payment Method</label>
                            <select class="form-control" id="payment-method" name="payment-method">
                                <option value="" selected disabled>Select payment method</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cash">Cash</option>
                                <option value="Bitcoin">Bitcoin</option>
                                <option value="POS">POS</option>
                                <option value="Post Master">Post Master</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="payment-note">Internal Payment Note</label>
                            <textarea class="form-control" id="payment-note" name="description" rows="5" placeholder="Internal Payment Note"></textarea>
                        </div>
                        <div class="form-group d-flex flex-wrap mb-0">
                            <button type="submit" class="btn btn-primary mr-1">Send</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Payment Sidebar -->

    <!-- Add Bill Sidebar -->
    <div class="modal modal-slide-in fade" id="add-bill-sidebar" aria-hidden="true">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">
                        <span class="align-middle">Add Bill</span>
                    </h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <form method="POST" action="{{route('add-guest-bill', $reservation->id)}}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="service">Service</label>
                            <input id="service" class="form-control" type="text" placeholder="Laundry" name="service" required/>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="payment-note">Description</label>
                            <textarea class="form-control" id="payment-note" rows="5" placeholder="Description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="price">Price</label>
                            <input id="price" class="form-control" type="number" name="price" placeholder="$1000" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="payment-time">Payment Time</label>
                            <select class="form-control" id="payment-time" onchange="billPaymentOptions(this.value)" name="payment-time">
                                <option value="" selected disabled>Select payment time</option>
                                <option value="Instant">Instant</option>
                                <option value="At Checkout">At Checkout</option>
                            </select>
                        </div>
                        <div class="form-group payment-div d-none">
                            <label class="form-label" for="payment-method">Payment Method</label>
                            <select class="form-control" id="payment-method" name="payment-method">
                                <option value="" selected disabled>Select payment method</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cash">Cash</option>
                                <option value="Bitcoin">Bitcoin</option>
                                <option value="POS">POS</option>
                                <option value="Post Master">Post Master</option>
                            </select>
                        </div>
                        <div class="form-group d-flex flex-wrap mb-0">
                            <button type="submit" class="btn btn-primary mr-1">Submit</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Bill Sidebar -->
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