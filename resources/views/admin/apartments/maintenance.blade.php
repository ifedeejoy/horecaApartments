@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/ag-grid/ag-grid.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/ag-grid/ag-theme-material.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" ref="{{ asset ('/app-assets/css/plugins/tables/table-ag-grid.min.css') }}">
@endsection

@section('content-header')
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Maintenance</h2>
                <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/home">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Maintenance
                    </li>
                </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="grid"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="app-todo.html">
                        <i class="mr-1" data-feather="check-square"></i>
                        <span class="align-middle">Todo</span>
                    </a>
                    <a class="dropdown-item" href="app-chat.html">
                        <i class="mr-1" data-feather="message-square"></i>
                        <span class="align-middle">Chat</span>
                    </a>
                    <a class="dropdown-item" href="app-email.html">
                        <i class="mr-1" data-feather="mail"></i>
                        <span class="align-middle">Email</span>
                    </a>
                    <a class="dropdown-item" href="app-calendar.html">
                        <i class="mr-1" data-feather="calendar"></i>
                        <span class="align-middle">Calendar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section id="basic-examples">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="ag-grid-btns d-flex justify-content-between flex-wrap mb-1">
                            <div class="dropdown sort-dropdown mb-1 mb-sm-0">
                                <button
                                    class="btn filter-btn dropdown-toggle border text-dark"
                                    type="button"
                                    id="dropdownMenuButton6"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    1 - 20 of 500
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton6">
                                    <a class="dropdown-item" href="javascript:void(0);">20</a>
                                    <a class="dropdown-item" href="javascript:void(0);">50</a>
                                    <a class="dropdown-item" href="javascript:void(0);">100</a>
                                    <a class="dropdown-item" href="javascript:void(0);">150</a>
                                </div>
                            </div>
                            <div class="ag-btns d-flex flex-wrap">
                                <input
                                    type="text"
                                    class="ag-grid-filter form-control w-50 mr-1 mb-1 mb-sm-0"
                                    id="filter-text-box"
                                    placeholder="Search...."
                                />
                                <div class="btn-export">
                                <button class="btn btn-primary ag-grid-export-btn">Export as CSV</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="myGrid" class="aggrid ag-theme-material"></div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-js')
    @parent
    <script src="{{ asset ('/app-assets/vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js') }}" defer></script>
@endsection

@section('page-js')
    <script src="{{ asset ('/app-assets/js/scripts/tables/table-ag-grid.js') }}" defer></script>
    @include('partials.form-response')
@endsection