/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
$(function() {
    'use strict';

    var dtUserTable = $('.user-list-table'),
        newUserSidebar = $('.new-user-modal'),
        newUserForm = $('.add-new-user');

    var assetPath = '../../../app-assets/',
        rateView = '/admin/apartment/';
    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
        rateView = '/admin/apartment/';
    }

    // Users List datatable
    if (dtUserTable.length) {
        dtUserTable.DataTable({
            ajax: '/api/rates', // JSON file to add data
            columns: [
                // columns according to JSON
                { data: 'id' },
                { data: 'name' },
                { data: 'amount' },
                { data: 'apartments.name' },
                { data: '' }
            ],
            columnDefs: [{
                    // For Responsive
                    className: 'control',
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0
                },
                {
                    // Rate
                    targets: 1,
                    responsivePriority: 4,
                    render: function(data, type, full, meta) {
                        var $name = full['name'];
                        var $apartmentType = full['apartments']['type'];
                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-left align-items-center">' +

                            '<div class="d-flex flex-column">' +
                            '<a href="#" class="user_name text-truncate"><span class="font-weight-bold">' +
                            $name +
                            '</span></a>' +
                            '<small class="emp_post text-muted">@' +
                            $apartmentType +
                            '</small>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    // Price
                    targets: 2,
                    render: function(data, type, full, meta) {
                        var $amount = new Intl.NumberFormat({ style: 'decimal', decimal: 2 }).format(full['amount']);
                        return "<span class='text-truncate align-middle'>" + $amount + '</span>';
                    }
                },
                {
                    // Apartment
                    targets: 3,
                    render: function(data, type, full, meta) {
                        var $apartment = full['apartments']['name'];
                        return "<span class='text-truncate align-middle'>" + $apartment + '</span>';
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return (
                            '<div class="btn-group">' +
                            '<a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">' +
                            feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="' +
                            rateView + full['apartments']['id'] +
                            '" class="dropdown-item">' +
                            feather.icons['file-text'].toSvg({ class: 'font-small-4 mr-50' }) +
                            'Details</a>' +
                            '<a href="javascript:;" onclick = deleteRate(' + full['id'] + ') class="dropdown-item delete-record">' +
                            feather.icons['trash-2'].toSvg({ class: 'font-small-4 mr-50' }) +
                            'Delete</a></div>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                }
            ],
            order: [
                [2, 'desc']
            ],
            dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                '<"col-lg-12 col-xl-3" l>' +
                '<"col-lg-12 col-xl-9 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                sLengthMenu: 'Show _MENU_',
                search: 'Search',
                searchPlaceholder: 'Search..'
            },
            // Buttons with Dropdown
            buttons: [{
                    extend: 'pdf',
                    className: 'add-new btn btn-primary mt-50',
                    messageTop: null,
                    messageBottom: null,
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                },
                {
                    extend: 'excel',
                    className: 'add-new btn btn-primary mt-50',
                    messageTop: null,
                    messageBottom: null,
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                },
                {
                    extend: 'print',
                    className: 'add-new btn btn-primary mt-50',
                    messageTop: null,
                    messageBottom: null,
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                },
                {
                    text: 'Add New Rate',
                    className: 'add-new btn btn-primary mt-50',
                    attr: {
                        'data-toggle': 'modal',
                        'data-target': '#modals-slide-in'
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details of ' + data['name'];
                        }
                    }),
                    type: 'column',
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table',
                        columnDefs: [{
                                targets: 1,
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
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            initComplete: function() {
                // Adding role filter once table initialized
                this.api()
                    .columns(3)
                    .every(function() {
                        var column = this;
                        var select = $(
                                '<select id="FilterApartment" class="form-control text-capitalize mb-md-0 mb-2"><option value=""> Select Apartment </option></select>'
                            )
                            .appendTo('.filter_apartment')
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
            }
        });
    }

    // To initialize tooltip with body container
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]',
        container: 'body'
    });
});