import { getUrl } from './core'

$(function() {
    'use strict';

    var dtUserTable = $('.user-list-table'),
        newUserSidebar = $('.new-user-modal'),
        newUserForm = $('.add-new-user'),
        statusObj = {
            'pending': { title: 'Pending', class: 'badge-light-warning' },
            'online': { title: 'Active', class: 'badge-light-success' },
            'offline': { title: 'Offline', class: 'badge-light-secondary' }
        };

    var assetPath = '../../../app-assets/',
        userView = '/admin/user/',
        userEdit = '/admin/edit-user/';
    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
        userView = assetPath + 'app/user/view';
        userEdit = assetPath + 'app/user/edit';
    }
    let currentUrl = getUrl(window.location.href)
    let apiUrl = currentUrl.replace('admin', 'api')
    let addNewBtn = {
        text: 'Add New User',
        className: 'add-new btn btn-primary mt-50',
        attr: {
            'data-toggle': 'modal',
            'data-target': '#modals-slide-in'
        },
        init: function(api, node, config) {
            $(node).removeClass('btn-secondary');
        }
    }
    let addNew
    if (currentUrl == '/admin/users/admin') {
        addNew = addNewBtn
    }
    // Users List datatable
    if (dtUserTable.length) {
        dtUserTable.DataTable({
            ajax: apiUrl, // JSON file to add data
            columns: [
                // columns according to JSON
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'type' },
                { data: 'status' },
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
                    // User full name and username
                    targets: 1,
                    responsivePriority: 4,
                    render: function(data, type, full, meta) {
                        var $name = full['name'],
                            $uname = full['name'],
                            $image = full['avatar'];
                        if ($image) {
                            // For Avatar image
                            var $output =
                                '<img src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" height="32" width="32">';
                        } else {
                            // For Avatar badge
                            var stateNum = Math.floor(Math.random() * 6) + 1;
                            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                            var $state = states[stateNum],
                                $name = full['name'],
                                $initials = $name.match(/\b\w/g) || [];
                            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                            $output = '<span class="avatar-content">' + $initials + '</span>';
                        }
                        var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : '';
                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-left align-items-center">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar ' +
                            colorClass +
                            ' mr-1">' +
                            $output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<a href="' + userView + full['id'] + '" class="user_name text-truncate"><span class="font-weight-bold">' +
                            $name +
                            '</span></a>' +
                            '<small class="emp_post text-muted">@' +
                            $uname +
                            '</small>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    // User Role
                    targets: 3,
                    render: function(data, type, full, meta) {
                        var $role = full['type'];
                        // let $property_manager = 'property manager'
                        // let $super_admin = 'super admin'
                        // var roleBadgeObj = {
                        //     agent: feather.icons['user'].toSvg({ class: 'font-medium-3 text-primary mr-50' }),
                        //     accountant: feather.icons['settings'].toSvg({ class: 'font-medium-3 text-warning mr-50' }),
                        //     owner: feather.icons['database'].toSvg({ class: 'font-medium-3 text-success mr-50' }),
                        //     $property_manager: feather.icons['edit-2'].toSvg({ class: 'font-medium-3 text-info mr-50' }),
                        //     $super_admin: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger mr-50' })
                        // };
                        return "<span class='text-truncate align-middle'>" + $role + '</span>';
                    }
                },
                {
                    // User Status
                    targets: 4,
                    render: function(data, type, full, meta) {
                        var $status = full['status'];
                        return (
                            '<span class="badge badge-pill ' +
                            statusObj[$status].class +
                            '" text-capitalized>' +
                            statusObj[$status].title +
                            '</span>'
                        );
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
                            userView + full['id'] +
                            '" class="dropdown-item">' +
                            feather.icons['file-text'].toSvg({ class: 'font-small-4 mr-50' }) +
                            'Details</a>' +
                            '<a href="' + userEdit + full['id'] + '" class="dropdown-item">' +
                            feather.icons['archive'].toSvg({ class: 'font-small-4 mr-50' }) +
                            'Edit</a>' +
                            '<a href="javascript:;" class="dropdown-item delete-record">' +
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
                '<"col-lg-12 col-xl-2" l>' +
                '<"col-lg-12 col-xl-10 pl-xl-75 pl-0"<"dt-action-buttons d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap mr-1"<"mr-1"f>B>>' +
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
                addNew
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
                                '<select id="UserRole" class="form-control text-capitalize mb-md-0 mb-2"><option value=""> Select Role </option></select>'
                            )
                            .appendTo('.user_role')
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
                // Adding status filter once table initialized
                this.api()
                    .columns(4)
                    .every(function() {
                        var column = this;
                        var select = $(
                                '<select id="FilterTransaction" class="form-control text-capitalize mb-md-0 mb-2xx"><option value=""> Select Status </option></select>'
                            )
                            .appendTo('.user_status')
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function(d, j) {
                                select.append(
                                    '<option value="' +
                                    statusObj[d].title +
                                    '" class="text-capitalize">' +
                                    statusObj[d].title +
                                    '</option>'
                                );
                            });
                    });
            }
        });
    }

    // Check Validity
    function checkValidity(el) {
        if (el.validate().checkForm()) {
            submitBtn.attr('disabled', false);
        } else {
            submitBtn.attr('disabled', true);
        }
    }

    // Form Validation
    if (newUserForm.length) {
        newUserForm.validate({
            errorClass: 'error',
            rules: {
                'user-fullname': {
                    required: true
                },
                'user-name': {
                    required: true
                },
                'user-email': {
                    required: true
                }
            }
        });

        newUserForm.on('submit', function(e) {
            var isValid = newUserForm.valid();
            e.preventDefault();
            if (isValid) {
                newUserSidebar.modal('hide');
            }
        });
    }

    // To initialize tooltip with body container
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]',
        container: 'body'
    });
});