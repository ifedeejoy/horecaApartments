<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="/dashboard">
                    <span class="brand-logo">
                        <img src="{{asset('app-assets/images/logo/logo.png')}}" class="img-fluid" alt="Horeca Apartments">
                    </span>
                    <h2 class="brand-text">{{ Str::limit(config('app.name'), 10) }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- Analytics --}}
            <li class=" nav-item"><a class="d-flex align-items-center" href="/dashboard"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span><span class="badge badge-light-warning badge-pill ml-auto mr-1">1</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['dashboard']) }}">
                        <a class="d-flex align-items-center" href="/dashboard">
                            <i data-feather="circle"></i><span class="menu-item" data-i18n="Analytics">Analytics</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class=" navigation-header">
                <span data-i18n="Front Desk">Front Desk</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="clipboard"></i>
                    <span class="menu-title text-truncate" data-i18n="Reservation Management">Reservation Management</span>
                </a>
                <ul class="menu-content">
                    @can('create reservations')
                    <li class="{{ setActive(['front-desk/new-reservation']) }} nav-item">
                        <a class="d-flex align-items-center" href="/front-desk/new-reservation"><i data-feather="plus"></i><span class="menu-title text-truncate" data-i18n="New Reservation">New Reservation</span></a>
                    </li>
                    @endcan
                    @can('manage reservations')
                    <li class="{{ setActive(['front-desk/reservations', 'front-desk/invoice/*', 'front-desk/reservation/*']) }} nav-item">
                        <a class="d-flex align-items-center" href="/front-desk/reservations"><i data-feather="clipboard"></i><span class="menu-title text-truncate" data-i18n="Reservations">Reservations</span></a>
                    </li>  
                    @endcan
                </ul>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i class="lni lni-chef-hat"></i>
                    <span class="menu-title text-truncate" data-i18n="Inhouse Guest Management">Inhouse Guest Management</span>
                </a>
                <ul class="menu-content">
                    @can('create reservations')
                    <li class="{{ setActive(['front-desk/new-checkin']) }} nav-item">
                        <a class="d-flex align-items-center" href="/front-desk/new-checkin"><i data-feather="plus"></i><span class="menu-title text-truncate" data-i18n="New Checkin">New Checkin</span></a>
                    </li>
                    @endcan
                    @can('manage reservations')
                    <li class="{{ setActive(['front-desk/inhouse-guests', 'front-desk/folio/*']) }} nav-item">
                        <a class="d-flex align-items-center" href="/front-desk/inhouse-guests"><i class="lni lni-chef-hat"></i><span class="menu-title text-truncate" data-i18n="Inhouse Guests">Inhouse Guests</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @can('view calendars')
            <li class="{{ setActive(['front-desk/calendar']) }} nav-item">
                <a class="d-flex align-items-center" href="/front-desk/calendar"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Calendar">Calendar</span></a>
            </li>   
            @endcan
            <li class="{{ setActive(['front-desk/channel-management']) }} nav-item">
                <a class="d-flex align-items-center" href="/front-desk/calendar">
                    <i data-feather="calendar"></i>
                    <span class="menu-title text-truncate" data-i18n="Channel Manager">Channel Manager</span>
                </a>
            </li>  
            
            {{-- Property Managament --}}
            <li class=" navigation-header">
                <span data-i18n="Properties">Property Management</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="{{ setActive(['admin/apartments', 'admin/apartment/*']) }} nav-item">
                <a class="d-flex align-items-center" href="/admin/apartments"><i class="lni lni-home"></i><span class="menu-title text-truncate" data-i18n="Apartments">Apartments</span></a>
            </li>
            <li class="{{ setActive(['admin/rates']) }} nav-item">
                <a class="d-flex align-items-center" href="/admin/rates"><i class="lni lni-calculator"></i><span class="menu-title text-truncate" data-i18n="Rates">Rates</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i class="lni lni-warning"></i><span class="menu-title text-truncate" data-i18n="Maintenance">Maintenance</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['admin/maintenance']) }}"><a class="d-flex align-items-center" href="/admin/maintenance"><i data-feather="circle"></i><span class="menu-item" data-i18n="List">Apartments</span></a>
                    </li>
                    <li class="{{ setActive(['admin/vendors/maintenance']) }}"><a class="d-flex align-items-center" href="/admin/vendors/maintenance"><i data-feather="circle"></i><span class="menu-item" data-i18n="View">Vendors</span></a>
                    </li>
                </ul>
            </li>

            {{-- Inventory Managament --}}
            <li class=" navigation-header">
                <span data-i18n="Inventory Management">Inventory Management</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="briefcase"></i><span class="menu-title text-truncate" data-i18n="Purchases">Purchases</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['inventory/purchases/pending']) }}"><a class="d-flex align-items-center" href="/inventory/purchases/pending"><i data-feather="loader"></i><span class="menu-item" data-i18n="List">Pending Orders</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/purchases/approved']) }}"><a class="d-flex align-items-center" href="/inventory/purchases/approved"><i data-feather="check"></i><span class="menu-item" data-i18n="View">Approved Orders</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/purchases/active']) }}"><a class="d-flex align-items-center" href="/inventory/purchases/active"><i data-feather="activity"></i><span class="menu-item" data-i18n="View">Active Orders</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/purchases/closed']) }}"><a class="d-flex align-items-center" href="/inventory/purchases/closed"><i data-feather="stop-circle"></i><span class="menu-item" data-i18n="View">Closed Orders</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/purchases/active']) }}"><a class="d-flex align-items-center" href="/inventory/purchases/active"><i data-feather="users"></i><span class="menu-item" data-i18n="View">Vendors</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="box"></i><span class="menu-title text-truncate" data-i18n="Stock">Stock</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['inventory/stock/in-stock']) }}"><a class="d-flex align-items-center" href="/inventory/stock/in-stock"><i data-feather="columns"></i><span class="menu-item" data-i18n="In Stock">In Stock</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/stock/out-of-stock']) }}"><a class="d-flex align-items-center" href="/inventory/stock/out-of-stock"><i data-feather="eye-off"></i><span class="menu-item" data-i18n="Out Of Stock">Out Of Stock</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/stock/critical']) }}"><a class="d-flex align-items-center" href="/inventory/stock/critical"><i data-feather="alert-circle"></i><span class="menu-item" data-i18n="Critical Items">Critical Items</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/stock/expiring']) }}"><a class="d-flex align-items-center" href="/inventory/stock/expiring"><i data-feather="alert-octagon"></i><span class="menu-item" data-i18n="Expiring Items">Expiring Items</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/stock/stock-count']) }}"><a class="d-flex align-items-center" href="/inventory/stock/stock-count"><i data-feather="archive"></i><span class="menu-item" data-i18n="Stock Count">Stock Count</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="external-link"></i><span class="menu-title text-truncate" data-i18n="Requisition">Requisition</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['inventory/requisition/requests']) }}"><a class="d-flex align-items-center" href="/inventory/requisition/requests"><i data-feather="loader"></i><span class="menu-item" data-i18n="Pending Requests">Pending Requests</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/requisition/approved']) }}"><a class="d-flex align-items-center" href="/inventory/requisition/approved"><i data-feather="check"></i><span class="menu-item" data-i18n="Approved Requests">Approved Requests</span></a>
                    </li>
                    <li class="{{ setActive(['inventory/requisition/declined']) }}"><a class="d-flex align-items-center" href="/inventory/requisition/declined"><i data-feather="stop-circle"></i><span class="menu-item" data-i18n="Declined Requests">Declined Requests</span></a>
                    </li>
                    <li class="{{ setActive(['inventor/requisition/manual']) }}"><a class="d-flex align-items-center" href="/inventor/requisition/manual"><i data-feather="plus"></i><span class="menu-item" data-i18n="Manual Requisition">Manual Requisition</span></a>
                    </li>
                </ul>
            </li>

            {{-- User Managament --}}
            @can('manage users')
            <li class=" navigation-header">
                <span data-i18n="Users">User Management</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="User">Users</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['admin/users/owners']) }}"><a class="d-flex align-items-center" href="/admin/users/owners"><i data-feather="circle"></i><span class="menu-item" data-i18n="List">Owners</span></a>
                    </li>
                    <li class="{{ setActive(['admin/users/agents']) }}"><a class="d-flex align-items-center" href="/admin/users/agents"><i data-feather="circle"></i><span class="menu-item" data-i18n="View">Agents</span></a>
                    </li>
                    <li class="{{ setActive(['admin/users/employees', 'admin/user/*']) }}"><a class="d-flex align-items-center" href="/admin/users/employees"><i data-feather="circle"></i><span class="menu-item" data-i18n="Edit">Employees</span></a>
                    </li>
                    <li class="{{ setActive(['admin/users/managers']) }}"><a class="d-flex align-items-center" href="/admin/users/managers"><i data-feather="circle"></i><span class="menu-item" data-i18n="Edit">Managers</span></a>
                    </li>
                    <li class="{{ setActive(['admin/users/admin']) }}"><a class="d-flex align-items-center" href="/admin/users/admin"><i data-feather="circle"></i><span class="menu-item" data-i18n="Edit">Admin</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i class="lni lni-blackboard"></i><span class="menu-title text-truncate" data-i18n="Blacklist">Blacklist</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['admin/employees-blacklist']) }}"><a class="d-flex align-items-center" href="/admin/employees-blacklist"><i data-feather="circle"></i><span class="menu-item" data-i18n="List">Employees</span></a>
                    </li>
                    <li class="{{ setActive(['admin/guest-blacklist']) }}"><a class="d-flex align-items-center" href="/admin/guests-blacklist"><i data-feather="circle"></i><span class="menu-item" data-i18n="View">Guests</span></a>
                    </li>
                    <li class="{{ setActive(['admin/agents-blacklist']) }}"><a class="d-flex align-items-center" href="/admin/agents-blacklist"><i data-feather="circle"></i><span class="menu-item" data-i18n="Edit">Agents</span></a>
                    </li>
                </ul>
            </li>
            @endcan
            

            <li class=" navigation-header">
                <span data-i18n="Finance">Finance</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i class="lni lni-wallet"></i><span class="menu-title text-truncate" data-i18n="User">Expenses</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['admin/guest-expenses']) }}"><a class="d-flex align-items-center" href="/admin/guest-expenses"><i data-feather="circle"></i><span class="menu-item" data-i18n="List">Guest Expenses</span></a>
                    </li>
                    <li class="{{ setActive(['admin/apartment-expenses']) }}"><a class="d-flex align-items-center" href="/admin/apartment-expenses"><i data-feather="circle"></i><span class="menu-item" data-i18n="View">Apartment Expenses</span></a>
                    </li>
                    <li class="{{ setActive(['admin/property-expenses']) }}"><a class="d-flex align-items-center" href="/admin/property-expenses"><i data-feather="circle"></i><span class="menu-item" data-i18n="Edit">Property Expenses</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i class="lni lni-revenue"></i><span class="menu-title text-truncate" data-i18n="User">Revenue</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['admin/apartment-revenue']) }}"><a class="d-flex align-items-center" href="/admin/apartment-revenue"><i data-feather="circle"></i><span class="menu-item" data-i18n="View">Apartment Revenue</span></a>
                    </li>
                    <li class="{{ setActive(['admin/property-revenue']) }}"><a class="d-flex align-items-center" href="/admin/property-revenue"><i data-feather="circle"></i><span class="menu-item" data-i18n="Edit">Property Revenue</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item mb-2"><a class="d-flex align-items-center" href="#"><i class="lni lni-revenue"></i><span class="menu-title text-truncate" data-i18n="User">Accounting</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['account/creditors']) }}"><a class="d-flex align-items-center" href="/account/creditors"><i data-feather="circle"></i><span class="menu-item" data-i18n="View">Creditors</span></a>
                    </li>
                    <li class="{{ setActive(['account/debtors']) }}"><a class="d-flex align-items-center" href="/account/debtors"><i data-feather="circle"></i><span class="menu-item" data-i18n="Edit">Debtors</span></a>
                    </li>
                    <li class="{{ setActive(['account/payroll']) }}"><a class="d-flex align-items-center" href="/account/payroll"><i data-feather="circle"></i><span class="menu-item" data-i18n="Edit">Payroll/Settlement</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->