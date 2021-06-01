@extends('layouts.app')

@section('vendor-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/editors/quill/quill.snow.css') }}">
@endsection

@section('page-css')
@parent
<link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/pages/app-user.css') }}">
<link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/forms/form-quill-editor.css') }}">
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
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#new-issue">
                        <i class="mr-1" data-feather="check-square"></i>
                        <span class="align-middle">New Issue</span>
                    </a>
                    <a class="dropdown-item" href="/admin/apartments">
                        <i class="mr-1" data-feather="check-square"></i>
                        <span class="align-middle">Apartments</span>
                    </a>
                    <a class="dropdown-item" href="/admin/rates">
                        <i class="mr-1" data-feather="briefcase"></i>
                        <span class="align-middle">Rates</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section>
        <div class="card p-1">
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <td>
                                <div class="btn-group"> 
                                    <a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown"> 
                                        <i data-feather="more-vertical"></i>
                                    </a> 
                                    <div class="dropdown-menu dropdown-menu-right"> 
                                        @if (is_null($issue->vendor_id))
                                        <a href="#" data-target="#assign-to-vendor" data-toggle="modal" onclick="assignVendor({{json_encode(array($issue->apartment->id, $issue->apartment->name, $issue->issue, $issue->id))}})" class="dropdown-item"> 
                                            <i data-feather="feather"></i>
                                            Assign To Vendor
                                        </a> 
                                        @endif
                                        <a href="#" class="dropdown-item" data-target="#edit-issue" data-toggle="modal" onclick="editIssue({{$issue->id}})"> 
                                            <i data-feather="edit-2"></i>
                                            Edit Issue
                                        </a> 
                                        <a href="#" class="dropdown-item" data-target="#update-issue" data-toggle="modal" onclick="updateIssue({{$issue->id}})"> 
                                            <i data-feather="folder-plus"></i>
                                            Update Issue
                                        </a> 
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-issue-{{$issue->id}}').submit();"  class="dropdown-item delete-record"> 
                                            <i data-feather="trash-2"></i>
                                            Delete Issue
                                        </a>
                                    </div> 
                                </div>
                                <form id="delete-issue-{{$issue->id}}" action="{{ route('delete-issue', $issue) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- Modal to report maintenance issue starts-->
    <div class="modal modal-slide-in new-user-modal fade" id="new-issue">
        <div class="modal-dialog new-user-modal-dialog">
            <form class="modal-content pt-0" method="POST" action="{{route('report-issue')}}" enctype="multipart/form-data">
                @csrf
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">New Issue</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="form-group">
                        <label class="form-label" for="apartment">Apartment</label>
                        <select class="select2 w-100" id="apartment" name="apartment">
                            <option label=" "></option>
                            @foreach ($apartments as $apartment)
                            <option value="{{$apartment->id}}">{{$apartment->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group d-none">
                        <textarea class="form-control" name="issue" id="issue" cols="3" rows="9" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="quill-editor" class="form-label">Issue</label>
                        <div id="quill-editor"></div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="btn btn-primary w-100" for="add-pictures">
                            <span class="d-none d-sm-block">Add Pictures</span>
                            <input class="form-control" type="file" id="add-pictures" name="issue-images[]" multiple hidden >
                            <span class="d-block d-sm-none">
                                <i class="mr-0" data-feather="edit"></i>
                            </span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="vendor-search">Select Vendor</label>
                        <select class="select2 w-100" id="vendor-search" name="vendor" data-placeholder="Search for vendor" onchange="selectVendor(this.value)">
                            <option label=" "></option>
                            <option value="0">Add new vendor</option>
                            @foreach ($vendors as $vendor)
                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-name">Vendor Name</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-name" placeholder="Mr Ochuko" disabled name="name">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-phone">Vendor Phone</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-phone" placeholder="+234902993882" disabled name="phone">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-email">Vendor Email</label>
                        <input type="email" inputmode="text" class="form-control d-none vendor-info" id="vendor-email" placeholder="ochukoandsons@gmail.com" disabled name="email">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-address">Address</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-address" placeholder="Lekki, Lagos" disabled name="address">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-business-name">Business Name</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-business-name" placeholder="Ochuko & Sons Enterpises" disabled name="business-name">
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="reset" class="btn btn-outline-secondary mr-1" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal modal-slide-in new-user-modal fade" id="assign-to-vendor">
        <div class="modal-dialog new-user-modal-dialog">
            <form class="modal-content pt-0" method="POST" id="assign-vendor-form" action="{{route('assign-vendor')}}">
                @csrf
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Assign To Vendor</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="form-group">
                        <label class="form-label" for="apartment">Apartment</label>
                        <select class="select2 w-100" id="assign-apartment" name="apartment"></select>
                    </div>
                    <input type="hidden" name="issue_id" id="issue_id">
                    <div class="form-group d-none">
                        <textarea class="form-control" name="issue" id="assign-issue" cols="3" rows="9" readonly>{!!$issue->issue!!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="issue-editor" class="form-label">Issue</label>
                        <div id="issue-editor"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="select-vendor">Select Vendor</label>
                        <select class="select2 w-100" id="select-vendor" name="vendor" data-placeholder="Search for vendor" onchange="selectVendor(this.value)">
                            <option label=" "></option>
                            <option value="0">Add new vendor</option>
                            @foreach ($vendors as $vendor)
                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-name">Vendor Name</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-name" placeholder="Mr Ochuko" disabled name="name">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-phone">Vendor Phone</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-phone" placeholder="+234902993882" disabled name="phone">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-email">Vendor Email</label>
                        <input type="email" inputmode="text" class="form-control d-none vendor-info" id="vendor-email" placeholder="ochukoandsons@gmail.com" disabled name="email">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-address">Address</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-address" placeholder="Lekki, Lagos" disabled name="address">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-business-name">Business Name</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-business-name" placeholder="Ochuko & Sons Enterpises" disabled name="business-name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cost">Cost</label>
                        <input type="number" inputmode="numeric" class="form-control" id="cost" placeholder="100000" name="cost">
                    </div>
                    <div class="form-group d-none">
                        <textarea class="form-control" name="cost-breakdown" id="assign-cost" cols="3" rows="9" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cost-editor" class="form-label">Cost Breakdown</label>
                        <div id="cost-editor"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="paid">Amount Paid</label>
                        <input type="number" inputmode="numeric" class="form-control" id="paid" placeholder="100000" name="paid">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="payment-method">Payment Method</label>
                        <select class="select2 w-100" id="payment-method" name="payment-method" data-placeholder="Select Payment Method">
                            <option label=" "></option>
                            <option>Bank Transfer</option>
                            <option>Cash</option>
                            <option>Credit</option>
                            <option>POS</option>
                        </select>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="reset" class="btn btn-outline-secondary mr-1" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal modal-slide-in new-user-modal fade" id="edit-issue">
        <div class="modal-dialog new-user-modal-dialog">
            <form class="modal-content pt-0" method="POST" id="edit-issue-form" action="{{route('edit-issue')}}">
                @csrf
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="edit-issue-modal">Edit Issue</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="form-group">
                        <label class="form-label" for="apartment">Apartment</label>
                        <select class="select2 w-100" id="edit-apartment" name="apartment"></select>
                    </div>
                    <input type="hidden" name="edited_issue" id="edited_issue">
                    <div class="form-group d-none">
                        <textarea class="form-control" name="issue" id="edit-issue-text" cols="3" rows="9" readonly>{!!$issue->issue!!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-issue-editor" class="form-label">Issue</label>
                        <div id="edit-issue-editor"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-vendor">Select Vendor</label>
                        <select class="select2 w-100" id="edit-vendor" name="vendor" data-placeholder="Search for vendor" onchange="selectVendor(this.value)">
                            <option label=" "></option>
                            <option value="0">Add new vendor</option>
                            @foreach ($vendors as $vendor)
                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-name">Vendor Name</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-name" placeholder="Mr Ochuko" disabled name="name">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-phone">Vendor Phone</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-phone" placeholder="+234902993882" disabled name="phone">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-email">Vendor Email</label>
                        <input type="email" inputmode="text" class="form-control d-none vendor-info" id="vendor-email" placeholder="ochukoandsons@gmail.com" disabled name="email">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-address">Address</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-address" placeholder="Lekki, Lagos" disabled name="address">
                    </div>
                    <div class="form-group vendor-group d-none">
                        <label class="form-label" for="vendor-business-name">Business Name</label>
                        <input type="text" inputmode="text" class="form-control d-none vendor-info" id="vendor-business-name" placeholder="Ochuko & Sons Enterpises" disabled name="business-name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cost">Cost</label>
                        <input type="number" inputmode="numeric" class="form-control" id="edit-cost" placeholder="100000" name="cost">
                    </div>
                    <div class="form-group d-none">
                        <textarea class="form-control" name="cost-breakdown" id="edit-cost-breakdown" cols="3" rows="9" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-cost-editor" class="form-label">Cost Breakdown</label>
                        <div id="edit-cost-editor"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="paid">Amount Paid</label>
                        <input type="number" inputmode="numeric" class="form-control" id="edit-paid" placeholder="100000" name="paid">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-payment-method">Payment Method</label>
                        <select class="select2 w-100" id="edit-payment-method" name="payment-method" data-placeholder="Select Payment Method">
                            <option label=" "></option>
                            <option>Bank Transfer</option>
                            <option>Cash</option>
                            <option>Credit</option>
                            <option>POS</option>
                        </select>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="reset" class="btn btn-outline-secondary mr-1" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal modal-slide-in new-user-modal fade" id="update-issue">
        <div class="modal-dialog new-user-modal-dialog">
            <form class="modal-content pt-0" method="POST" id="update-issue-form" action="{{route('update-issue')}}">
                @csrf
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="update-issue-modal">Update Issue</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="form-group">
                        <label class="form-label" for="apartment">Apartment</label>
                        <select class="select2 w-100" id="issue-apartment" name="apartment"></select>
                    </div>
                    <input type="hidden" name="updated-issue" id="updated-issue">
                    <div class="form-group">
                        <label for="update-issue-editor" class="form-label">Issue</label>
                        <div id="update-issue-editor"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="issue-vendor">Select Vendor</label>
                        <select class="select2 w-100" id="issue-vendor" name="vendor" data-placeholder="Search for vendor"></select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="issue-status">Status</label>
                        <select class="select2 w-100" id="issue-status" name="status" data-placeholder="Select Status">
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <div class="form-group d-none">
                        <textarea class="form-control" name="cost-breakdown" id="update-cost-breakdown" cols="3" rows="9" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="update-cost-editor" class="form-label">Cost Breakdown</label>
                        <div id="update-cost-editor"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cost">Cost</label>
                        <input type="number" inputmode="numeric" class="form-control" id="update-cost" placeholder="100000" readonly name="cost">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="paid">Paid</label>
                        <input type="number" inputmode="numeric" class="form-control" id="update-prev-paid" placeholder="100000" readonly name="prev-paid">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="balance">Balance</label>
                        <input type="number" inputmode="numeric" class="form-control" id="update-balance" placeholder="100000" readonly name="balance">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="paid">Additional Payment</label>
                        <input type="number" inputmode="numeric" class="form-control" id="update-paid" placeholder="100000" name="paid">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="update-payment-method">Payment Method</label>
                        <select class="select2 w-100" id="update-payment-method" name="payment-method" data-placeholder="Select Payment Method">
                            <option label=" "></option>
                            <option>Bank Transfer</option>
                            <option>Cash</option>
                            <option>Credit</option>
                            <option>POS</option>
                        </select>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="reset" class="btn btn-outline-secondary mr-1" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal to report maintenance issue Ends-->
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
    <script src="{{ asset ('/app-assets/vendors/js/editors/quill/quill.min.js') }}" defer></script>
@endsection

@section('page-js')
    <script src="{{ asset ('/app-assets/js/scripts/forms/form-quill-editor.js') }}" defer></script>
    <script src="{{ asset ('/js/core.js') }}" defer></script>
    <script src="{{ asset ('/js/maintenance-list.js') }}" defer></script>
    @include('partials.form-response')
@endsection