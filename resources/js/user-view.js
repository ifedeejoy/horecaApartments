import { getUrl } from './core';

let moment = require('moment')
$(function() {
    'use strict';
    let currentUrl = getUrl(window.location.href)
    let userId = currentUrl.match(/\d+/)[0]
    var dtInvoiceTable = $('.invoice-list-table'),
        assetPath = '../../../app-assets/',
        invoicePreview = '/front-desk/reservation/',
        invoiceAdd = '/front-desk/new-reservation',
        invoiceDownload = '/print-invoice/';

    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
        invoicePreview = assetPath + 'app/invoice/preview';
        invoiceAdd = assetPath + 'app/invoice/add';
        invoiceEdit = assetPath + 'app/invoice/edit';
    }
    // datatable
    if (dtInvoiceTable.length) {
        var dtInvoice = dtInvoiceTable.DataTable({
            ajax: '/api/user-reservations/' + userId, // JSON file to add data
            autoWidth: false,
            columns: [
                // columns according to JSON
                { data: 'id' },
                { data: 'reference' },
                { data: 'guest.name' },
                { data: 'apartments.name' },
                { data: 'checkin' },
                { data: 'checkout' },
                { data: 'reservation_payments.total' },
                { data: 'reservation_payments.balance' },
                { data: 'reservation_payments.[0].payment_status' },
                { data: '' }

            ],
            columnDefs: [{
                    // For Responsive
                    className: 'control',
                    responsivePriority: 2,
                    targets: 0
                },
                {
                    // Invoice ID
                    targets: 1,
                    width: '46px',
                    render: function(data, type, full, meta) {
                        var $invoiceId = full['reference'];
                        // Creates full output for row
                        var $rowOutput = '<a class="font-weight-bold" href="' + invoicePreview + full['id'] + '"> #' + $invoiceId + '</a>';
                        return $rowOutput;
                    }
                },
                {
                    // Client name and Service
                    targets: 2,
                    responsivePriority: 4,
                    width: '270px',
                    render: function(data, type, full, meta) {
                        var $name = full['guest']['name'],
                            $email = full['guest']['email'],
                            $image = full['avatar'],
                            stateNum = Math.floor(Math.random() * 6),
                            states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'],
                            $state = states[stateNum],
                            $name = full['guest']['name'],
                            $initials = $name.match(/\b\w/g) || [];
                        $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                        if ($image) {
                            // For Avatar image
                            var $output =
                                '<img  src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" width="32" height="32">';
                        } else {
                            // For Avatar badge
                            $output = '<div class="avatar-content">' + $initials + '</div>';
                        }
                        // Creates full output for row
                        var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : ' ';

                        var $rowOutput =
                            '<div class="d-flex justify-content-left align-items-center">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar' +
                            colorClass +
                            'mr-50">' +
                            $output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<h6 class="user-name text-truncate mb-0">' +
                            $name +
                            '</h6>' +
                            '<small class="text-truncate text-muted">' +
                            $email +
                            '</small>' +
                            '</div>' +
                            '</div>';
                        return $rowOutput;
                    }
                },
                {
                    // Room Type
                    targets: 3,
                    width: '73px',
                    render: function(data, type, full, meta) {
                        var $roomType = full['apartments']['name'];
                        return '<span class="d-none">' + $roomType + '</span>' + $roomType;
                    }
                },
                {
                    // Expected Arrival
                    targets: 4,
                    width: '73px',
                    render: function(data, type, full, meta) {
                        var $expectedArrival = full['checkin'];
                        // Creates full output for row
                        var $expectOutput =
                            '<span class="d-none">' +
                            moment($expectedArrival).format('YYYYMMDD') +
                            '</span>' +
                            moment($expectedArrival).format('DD MMM YYYY');
                        $expectedArrival;
                        return $expectOutput;
                    }
                },
                {
                    // Expected Departure
                    targets: 5,
                    width: '73px',
                    render: function(data, type, full, meta) {
                        var $expectedArrival = full['checkout'];
                        // Creates full output for row
                        var $expectOutput =
                            '<span class="d-none">' +
                            moment($expectedArrival).format('YYYYMMDD') +
                            '</span>' +
                            moment($expectedArrival).format('DD MMM YYYY');
                        $expectedArrival;
                        return $expectOutput;
                    }
                },
                {
                    // Total Invoice Amount
                    targets: 6,
                    width: '73px',
                    render: function(data, type, full, meta) {
                        let payments = full.reservation_payments
                        var $total = new Intl.NumberFormat().format(payments[0].total);
                        return '<span class="d-none">' + $total + '</span>₦' + $total;
                    }
                },
                {
                    // Client Balance/Status
                    targets: 7,
                    width: '98px',
                    render: function(data, type, full, meta) {
                        let payments = full.reservation_payments
                        var $balance = payments[0].balance;
                        if ($balance === 0) {
                            var $badge_class = 'badge-light-success';
                            return '<span class="badge badge-pill ' + $badge_class + '" text-capitalized> Paid </span>';
                        } else {
                            return '<span class="d-none">' + new Intl.NumberFormat().format($balance) + '</span>₦' + new Intl.NumberFormat().format($balance);
                        }
                    }
                },

                {
                    targets: 8,
                    visible: false,
                    render: function(data, type, full, meta) {
                        let payments = full.reservation_payments
                        var $status = payments[0].payment_status
                        return $status
                    }
                },

                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    width: '80px',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return (
                            '<div class="d-flex align-items-center col-actions">' +
                            '<a class="mr-1" href="javascript:void(0);" onclick="checkinGuest(' + full['id'] + ')" data-toggle="tooltip" data-placement="top" title="Checkin">' +
                            feather.icons['check'].toSvg({ class: 'font-medium-2' }) +
                            '</a>' +
                            '<a class="mr-1" href="' +
                            invoicePreview + full['id'] +
                            '" data-toggle="tooltip" data-placement="top" title="View Reservation">' +
                            feather.icons['eye'].toSvg({ class: 'font-medium-2' }) +
                            '</a>' +
                            '<div class="dropdown">' +
                            '<a class="btn btn-sm btn-icon px-0" data-toggle="dropdown">' +
                            feather.icons['more-vertical'].toSvg({ class: 'font-medium-2' }) +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="' + invoiceDownload + full['reference'] + '" target="_blank" class="dropdown-item">' +
                            feather.icons['download'].toSvg({ class: 'font-small-4 mr-50' }) +
                            'Download</a>' +
                            '<a href="javascript:void(0);" onclick=deleteReservation(' + full['id'] + ') class="dropdown-item">' +
                            feather.icons['trash'].toSvg({ class: 'font-small-4 mr-50' }) +
                            'Delete</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                }
            ],
            order: [
                [1, 'desc']
            ],
            dom: '<"row d-flex justify-content-between align-items-center m-1"' +
                '<"col-lg-6 d-flex align-items-center"l<"dt-action-buttons text-xl-right text-lg-left text-lg-right text-left "B>>' +
                '<"col-lg-6 d-flex align-items-center justify-content-lg-end flex-lg-nowrap flex-wrap pr-lg-1 p-0"f<"payment_status ml-sm-2 mt-2">>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                sLengthMenu: 'Show _MENU_',
                search: 'Search',
                searchPlaceholder: 'Search Reservations',
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            // Buttons with Dropdown
            buttons: [],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details of ' + data['guest']['name'];
                        }
                    }),
                    type: 'column',
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table',
                        columnDefs: [{
                                targets: 2,
                                visible: false
                            },
                            {
                                targets: 3,
                                visible: false
                            }
                        ]
                    })
                }
            },
            initComplete: function() {
                $(document).find('[data-toggle="tooltip"]').tooltip();
                // Adding role filter once table initialized
                this.api()
                    .columns(8)
                    .every(function() {
                        var column = this;
                        var select = $(
                                '<select id="UserRole" class="form-control ml-50 text-capitalize"><option value=""> Select Status </option></select>'
                            )
                            .appendTo('.payment_status')
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function(d, j) {
                                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                            });
                    });
            },
            drawCallback: function() {
                $(document).find('[data-toggle="tooltip"]').tooltip();
            }
        });
    }
});