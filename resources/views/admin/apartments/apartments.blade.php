@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/page-knowledge-base.css') }}">
@endsection

@section('content-header')
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Aparments</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Aparments
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrumb-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="modal" data-target="#add-new-apartment"><i data-feather="plus"></i><i class="lni lni-home"></i></button>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <section id="knowledge-base-search">
        <div class="row">
            <div class="col-12">
                <div class="card knowledge-base-bg text-center" style="background-image: url('{{ asset ('/app-assets/images/banner/banner.png')}}">
                    <div class="card-body">
                        <h2 class="text-primary">All Apartments</h2>
                        <form class="kb-search-input mt-2">
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="search"></i></span>
                                </div>
                                <input type="text" class="form-control" id="searchbar" placeholder="Search for apartment" />
                            </div>
                        </form>
                        @can('view reservations')
                        e be things
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </section>
                
    <section id="knowledge-base-content">
        <div class="row kb-search-content-info match-height">
            <!-- apartments card -->
            @foreach ($apartments as $apartment)
            <div class="col-md-4 col-sm-6 col-12 kb-search-content">
                <div class="card">
                    <a href="/admin/apartment/{{$apartment->id}}">
                        <img src="{{ asset('/images/apartments.svg') }}" class="card-img-top" alt="knowledge-base-image" />

                        <div class="card-body text-center">
                            <h4>{{$apartment->name}}</h4>
                            <p class="text-body mt-1 mb-0">
                                {{$apartment->description}}
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach

            <!-- no result -->
            <div class="col-12 text-center no-result no-items">
                <h4 class="mt-4">Search result not found!!</h4>
            </div>
        </div>
    </section>

    <div class="modal modal-slide-in fade" id="add-new-apartment" aria-hidden="true">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">
                        <span class="align-middle">New Apartment</span>
                    </h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <form method="POST" action="{{route('create-apartment')}}">
                        @csrf
                        <div class="form-group">
                            <label for="aparment-name" class="form-label">Apartment Name</label>
                            <input type="text" class="form-control" name="apartment-name" id="aparment-name" placeholder="Lola's Court" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="apartment-type">Apartment Type</label>
                            <select class="select2 w-100" id="apartment-type" name="apartment-type">
                                <option label=" "></option>
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
                            <textarea class="form-control" name="apartment-description" id="apartment-description" cols="3" rows="9" placeholder="Apartment Description"></textarea>
                        </div>
                        <div class="input-group w-100">
                            <label class="form-label" for="max-guests">Max Guests(s)</label>
                            <input type="text" id="max-guests" name="max-guests" class="touchspin input-control-lg" value="{number}" />
                        </div>
                        <div class="input-group w-100 mt-2">
                            <label class="form-label" for="beds">Bed(s)</label>
                            <input type="text" id="beds" name="beds" class="touchspin input-control-lg" value="{number}" />
                        </div>
                        <hr class="my-1 mt-2">
                        <div class="form-group">
                            <label class="form-label" for="apartment-owner">Apartment Owner</label>
                            <select class="select2 w-100" id="apartment-owner" name="apartment-owner">
                                <option label=" "></option>
                                @foreach ($owners as $owner)
                                <option value="{{$owner->id}}">{{$owner->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="apartment-address">Address</label>
                            <input type="text" id="apartment-address" name="apartment-address" class="form-control" placeholder="98  Borough bridge Road, Birmingham" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="apartment-country">Country</label>
                            <select class="select2 w-100" id="apartment-country" name="apartment-country">
                                <option label=" "></option>
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
@endsection

@section('vendor-js')
    @parent
    <script src="{{ asset ('/app-assets/vendors/js/forms/select/select2.full.min.js') }}" defer></script>
@endsection

@section('page-js')
    <script src="{{ asset ('/app-assets/js/scripts/pages/page-knowledge-base.js')}}" defer></script>
    <script type="module" defer>
        $("#apartment-type").select2({
            placeholder: 'Select apartment type'
        })
        $("#apartment-country").select2({
            placeholder: 'Select Country'
        })
        $("#apartment-owner").select2({
            placeholder: 'Select apartment owner'
        })
        $('.touchspin').TouchSpin({
            buttondown_class: 'btn btn-primary',
            buttonup_class: 'btn btn-primary',
            buttondown_txt: feather.icons['minus'].toSvg(),
            buttonup_txt: feather.icons['plus'].toSvg(),
            max: 1000
        });
    </script>
    @include('partials.form-response')
@endsection