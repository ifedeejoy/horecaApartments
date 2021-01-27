/*=========================================================================================
    File Name: app-invoice-list.js
    Description: app-invoice-list Javascripts 
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
   Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function() {
    'use strict';

    var dtInvoiceTable = $('.invoice-list-table'),
        assetPath = '../../../app-assets/',
        invoicePreview = '/front-desk/invoice',
        invoiceAdd = '/front-desk/new-reservation',
        invoiceEdit = 'app-invoice-edit.html';

    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
        invoicePreview = assetPath + 'app/invoice/preview';
        invoiceAdd = assetPath + 'app/invoice/add';
        invoiceEdit = assetPath + 'app/invoice/edit';
    }

    // datatable
    if (dtInvoiceTable.length) {
        var dtInvoice = dtInvoiceTable.DataTable({
            ajax: assetPath + 'data/invoice-list.json', // JSON file to add data
            autoWidth: false,
            columns: [
                // columns according to JSON
                { data: 'responsive_id' },
                { data: 'reservation_id' },
                { data: 'client_name' },
                { data: 'checkin' },
                { data: 'checkout' },
                { data: 'total' },
                { data: 'reserved_on' },
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
                        var $invoiceId = full['reservation_id'];
                        // Creates full output for row
                        var $rowOutput = '<a class="font-weight-bold" href="' + invoicePreview + '"> #' + $invoiceId + '</a>';
                        return $rowOutput;
                    }
                },
                {
                    // Client name and Service
                    targets: 2,
                    responsivePriority: 4,
                    width: '270px',
                    render: function(data, type, full, meta) {
                        var $name = full['client_name'],
                            $email = full['email'],
                            $image = full['avatar'],
                            stateNum = Math.floor(Math.random() * 6),
                            states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'],
                            $state = states[stateNum],
                            $name = full['client_name'],
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
                    // Checkin
                    targets: 3,
                    width: '73px',
                    render: function(data, type, full, meta) {
                        var $checkin = new Date(full['checkin']);
                        // Creates full output for row
                        var $expectOutput =
                            '<span class="d-none">' +
                            moment($checkin).format('YYYYMMDD') +
                            '</span>' +
                            moment($checkin).format('DD MMM YYYY');
                        $checkin;
                        return $expectOutput;
                    }
                },
                {
                    // Checkout
                    targets: 4,
                    width: '73px',
                    render: function(data, type, full, meta) {
                        var $checkout = new Date(full['checkout']);
                        // Creates full output for row
                        var $expectOutput =
                            '<span class="d-none">' +
                            moment($checkout).format('YYYYMMDD') +
                            '</span>' +
                            moment($checkout).format('DD MMM YYYY');
                        $checkout;
                        return $expectOutput;
                    }
                },
                {
                    // Total Invoice Amount
                    targets: 5,
                    width: '73px',
                    render: function(data, type, full, meta) {
                        var $total = full['total'];
                        return '<span class="d-none">' + $total + '</span>$' + $total;
                    }
                },

                {
                    // Reservation Date
                    targets: 6,
                    width: '130px',
                    render: function(data, type, full, meta) {
                        var $dueDate = new Date(full['reserved_on']);
                        // Creates full output for row
                        var $rowOutput =
                            '<span class="d-none">' +
                            moment($dueDate).format('YYYYMMDD') +
                            '</span>' +
                            moment($dueDate).format('DD MMM YYYY');
                        $dueDate;
                        return $rowOutput;
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
                            '<div class="d-flex justify-content-center align-items-center col-actions">' +
                            '<a href="' +
                            invoicePreview +
                            '" data-toggle="tooltip" data-placement="top" title="View Reservation">' +
                            feather.icons['eye'].toSvg({ class: 'font-medium-2' }) +
                            '</a>' +
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
            buttons: [{
                text: 'New Reservation',
                className: 'btn btn-primary btn-add-record ml-2',
                action: function(e, dt, button, config) {
                    window.location = invoiceAdd;
                }
            }],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details of ' + data['client_name'];
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
            },
            drawCallback: function() {
                $(document).find('[data-toggle="tooltip"]').tooltip();
            }
        });
    }
});