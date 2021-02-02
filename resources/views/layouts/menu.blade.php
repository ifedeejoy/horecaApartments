<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="/front-desk/home">
                    <span class="brand-logo">
                        <img src="{{asset('app-assets/images/logo/logo.png')}}" class="img-fluid" alt="Horeca Apartments">
                    </span>
                    <h2 class="brand-text">Kimberly's</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- Analytics --}}
            <li class=" nav-item"><a class="d-flex align-items-center" href="/front-desk/home"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span><span class="badge badge-light-warning badge-pill ml-auto mr-1">1</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['front-desk/home']) }}">
                        <a class="d-flex align-items-center" href="/front-desk/home">
                            <i data-feather="circle"></i><span class="menu-item" data-i18n="Analytics">Analytics</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Reservation --}}
            <li class=" navigation-header">
                <span data-i18n="Reservations">Reservation Management</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="{{ setActive(['front-desk/new-reservation']) }} nav-item">
                <a class="d-flex align-items-center" href="/front-desk/new-reservation"><i data-feather="plus"></i><span class="menu-title text-truncate" data-i18n="New Reservation">New Reservation</span></a>
            </li>
            <li class="{{ setActive(['front-desk/reservations', 'front-desk/invoice/*']) }} nav-item">
                <a class="d-flex align-items-center" href="/front-desk/reservations"><i data-feather="clipboard"></i><span class="menu-title text-truncate" data-i18n="Reservations">Reservations</span></a>
            </li>
            <li class="{{ setActive(['front-desk/calendar']) }} nav-item">
                <a class="d-flex align-items-center" href="/front-desk/calendar"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Calendar">Calendar</span></a>
            </li>

            {{-- Reservation --}}
            <li class=" navigation-header">
                <span data-i18n="Reservations">Inhouse Guest Management</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="{{ setActive(['front-desk/new-checkin']) }} nav-item">
                <a class="d-flex align-items-center" href="/front-desk/new-checkin"><i data-feather="plus"></i><span class="menu-title text-truncate" data-i18n="New Checkin">New Checkin</span></a>
            </li>
            <li class="{{ setActive(['front-desk/inhouse-guests', 'front-desk/folio/*']) }} nav-item">
                <a class="d-flex align-items-center" href="/front-desk/inhouse-guests"><i class="lni lni-chef-hat"></i><span class="menu-title text-truncate" data-i18n="Inhouse Guests">Inhouse Guests</span></a>
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
                    <li class="{{ setActive(['maintenance/apartments']) }}"><a class="d-flex align-items-center" href="/maintenance/apartments"><i data-feather="circle"></i><span class="menu-item" data-i18n="List">Apartments</span></a>
                    </li>
                    <li class="{{ setActive(['maintenance/vendors']) }}"><a class="d-flex align-items-center" href="/maintenance/vendors"><i data-feather="circle"></i><span class="menu-item" data-i18n="View">Vendors</span></a>
                    </li>
                </ul>
            </li>

            {{-- User Managament --}}
            <li class=" navigation-header">
                <span data-i18n="Users">User Management</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="User">Users</span></a>
                <ul class="menu-content">
                    <li class="{{ setActive(['admin/owners']) }}"><a class="d-flex align-items-center" href="/admin/owners"><i data-feather="circle"></i><span class="menu-item" data-i18n="List">Owners</span></a>
                    </li>
                    <li class="{{ setActive(['admin/agents']) }}"><a class="d-flex align-items-center" href="/admin/agents"><i data-feather="circle"></i><span class="menu-item" data-i18n="View">Agents</span></a>
                    </li>
                    <li class="{{ setActive(['admin/employees']) }}"><a class="d-flex align-items-center" href="/admin/employees"><i data-feather="circle"></i><span class="menu-item" data-i18n="Edit">Employees</span></a>
                    </li>
                </ul>
            </li>
            <li class="{{ setActive(['admin/access-control']) }} nav-item">
                <a class="d-flex align-items-center" href="/admin/access-control"><i class="lni lni-key"></i><span class="menu-title text-truncate" data-i18n="Access Control">Acess Control</span></a>
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