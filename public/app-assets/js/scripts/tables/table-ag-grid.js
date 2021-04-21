/*=========================================================================================
    File Name: ag-grid.js
    Description: Aggrid Table
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function() {
    'use strict';

    /*** COLUMN DEFINE ***/
    var columnDefs = [{
            headerName: 'Apartment',
            field: 'name',
            editable: false,
            sortable: true,
            filter: true,
            width: 175,
            filter: true,
            checkboxSelection: true,
            headerCheckboxSelectionFilteredOnly: true,
            headerCheckboxSelection: true
        },
        {
            headerName: 'Apartment Type',
            field: 'type',
            editable: false,
            sortable: true,
            filter: true,
            width: 175
        },
        {
            headerName: 'Beds',
            field: 'beds',
            editable: true,
            sortable: true,
            filter: true,
            width: 125
        },
        {
            headerName: 'Availability Status',
            field: 'status',
            editable: false,
            sortable: true,
            filter: true,
            width: 250
        },
        {
            headerName: 'Maintenance Status',
            field: 'maintenance_status',
            editable: true,
            sortable: true,
            filter: true,
            width: 125
        },
        {
            headerName: 'Address',
            field: 'address',
            editable: false,
            sortable: true,
            filter: true,
            width: 150
        }
    ];

    /*** GRID OPTIONS ***/
    var gridOptions = {
        columnDefs: columnDefs,
        rowSelection: 'multiple',
        floatingFilter: true,
        defaultColDef: {
            filter: 'agTextColumnFilter',
            enableColResize: true
        },
        pagination: true,
        paginationPageSize: 20,
        pivotPanelShow: 'always',
        colResizeDefault: 'shift',
        animateRows: true
    };

    /*** DEFINED TABLE VARIABLE ***/
    var gridTable = document.getElementById('myGrid');

    var assetPath = '/app-assets/';
    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
    }

    /*** GET TABLE DATA FROM URL ***/

    agGrid.simpleHttpRequest({ url: '/api/apartments' }).then(function(data) {
        console.log(data);
        gridOptions.api.setRowData(data);
    });

    /*** FILTER TABLE ***/
    function updateSearchQuery(val) {
        gridOptions.api.setQuickFilter(val);
    }

    $('.ag-grid-filter').on('keyup', function() {
        updateSearchQuery($(this).val());
    });

    /*** CHANGE DATA PER PAGE ***/
    function changePageSize(value) {
        gridOptions.api.paginationSetPageSize(Number(value));
    }

    $('.sort-dropdown .dropdown-item').on('click', function() {
        var $this = $(this);
        changePageSize($this.text());
        $('.filter-btn').text('1 - ' + $this.text() + ' of 500');
    });

    /*** EXPORT AS CSV BTN ***/
    $('.ag-grid-export-btn').on('click', function(params) {
        gridOptions.api.exportDataAsCsv();
    });

    /*** INIT TABLE ***/
    new agGrid.Grid(gridTable, gridOptions);

    /*** SET OR REMOVE EMAIL AS PINNED DEPENDING ON DEVICE SIZE ***/

    if ($(window).width() < 768) {
        gridOptions.columnApi.setColumnPinned('name', null);
    } else {
        gridOptions.columnApi.setColumnPinned('name', 'left');
    }
    $(window).on('resize', function() {
        if ($(window).width() < 768) {
            gridOptions.columnApi.setColumnPinned('name', null);
        } else {
            gridOptions.columnApi.setColumnPinned('name', 'left');
        }
    });
});