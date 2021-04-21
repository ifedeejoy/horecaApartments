@extends('layouts.app')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/calendars/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-calendar.css') }}">
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/form-validation.css') }}">
@endsection

@section('content')
    <!-- Full calendar start -->
    <section>
        <div class="app-calendar overflow-hidden border">
            <div class="row no-gutters">
                <!-- Sidebar -->
                <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                    <div class="sidebar-wrapper">
                        <div class="card-body d-flex justify-content-center">
                            <a href="/front-desk/sync-events" class="btn btn-primary btn-toggle-sidebar btn-block">
                                <span class="align-middle">Sync Calendar</span>
                            </a>
                        </div>
                        <div class="card-body pb-0">
                            <h5 class="section-label mb-1">
                                <span class="align-middle">Filter</span>
                            </h5>
                            <div class="custom-control custom-checkbox mb-1">
                                <input type="checkbox" class="custom-control-input select-all" id="select-all" checked />
                                <label class="custom-control-label" for="select-all">View All</label>
                            </div>
                            <div class="calendar-events-filter">
                                <div class="custom-control custom-control-danger custom-checkbox mb-1">
                                    <input type="checkbox" class="custom-control-input input-filter" id="inhouse" data-value="inhouse" checked />
                                    <label class="custom-control-label" for="inhouse">Inhouse</label>
                                </div>
                                <div class="custom-control custom-control-primary custom-checkbox mb-1">
                                    <input type="checkbox" class="custom-control-input input-filter" id="reserved" data-value="reserved" checked />
                                    <label class="custom-control-label" for="reserved">Reserved</label>
                                </div>
                                <div class="custom-control custom-control-info custom-checkbox mb-1">
                                    <input type="checkbox" class="custom-control-input input-filter" id="googlecalendar" data-value="googlecalendar" checked />
                                    <label class="custom-control-label" for="googlecalendar">Google Calendar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <img src="../../../app-assets/images/pages/calendar-illustration.png" alt="Calendar illustration" class="img-fluid" />
                    </div>
                </div>
                <!-- /Sidebar -->

                <!-- Calendar -->
                <div class="col position-relative">
                    <div class="card shadow-none border-0 mb-0 rounded-0">
                        <div class="card-body pb-0">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                <!-- /Calendar -->
                <div class="body-content-overlay"></div>
            </div>
        </div>
    </section>
    <!-- Full calendar end -->
@endsection
@section('vendor-js')
    @parent
    <script src="{{ asset ('/app-assets/vendors/js/calendar/fullcalendar.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/extensions/moment.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/forms/select/select2.full.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}" defer></script>
@endsection

@section('page-js')
    @parent
    <script src="{{ asset ('/js/calendar-events.js') }}" defer></script>
    <script src="{{ asset ('/js/calendar.js') }}" defer></script>
@endsection