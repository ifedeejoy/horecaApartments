$("#vendors-list-table").DataTable({
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
    order: [
        [1, 'desc']
    ],
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
            text: 'New Vendor',
            className: 'add-new btn btn-primary mt-50',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#new-vendor'
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
})

$("#vendor-type").select2({
    placeholder: 'Select vendor type'
})