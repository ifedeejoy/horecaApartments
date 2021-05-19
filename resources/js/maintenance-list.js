$("#maintenance-list-table").DataTable({
    dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
        '<"col-lg-12 col-xl-3" l>' +
        '<"col-lg-12 col-xl-9 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
        '>t' +
        '<"d-flex justify-content-between mx-2 row mb-1"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
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
            text: 'Report Issue',
            className: 'add-new btn btn-primary mt-50',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#new-issue'
            },
            init: function(api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        }
    ]
})

$("#apartment").select2({
    placeholder: 'Select Apartment'
})
$("#vendor-search").select2({
    placeholder: 'Select Vendor'
})

$("#assign-apartment").select2({
    placeholder: 'Select Apartment'
})
$("#select-vendor").select2({
    placeholder: 'Select Vendor'
})
$("#payment-method").select2()

let editor = new Quill('#quill-editor', {
    placeholder: 'Description',
    theme: 'snow'
})

let issueEditor = new Quill('#issue-editor', {
    placeholder: 'Issue',
    theme: 'snow'
})

let costEditor = new Quill('#cost-editor', {
    placeholder: 'Cost Breakdown',
    theme: 'snow'
})

window.assignVendor = function(apartment) {
    let apartmentId = apartment[0]
    let apartmentName = apartment[1]
    let apartmentIssue = apartment[2]
    let issue = apartment[3]
    $("#issue_id").val(issue)
    $("#assign-apartment").append("<option value='" + apartmentId + "'>" + apartmentName + "</option>")
    let content = apartmentIssue
    issueEditor.clipboard.dangerouslyPasteHTML(content)
}

// copy issue text into html only text area from quill editor
let htmlContent = document.getElementById('issue')
editor.on('text-change', function(params) {
    let htmlText = editor.root.innerHTML
    htmlContent.innerHTML = htmlText
})

// copy issue text into html only text area from quill editor
let issueContent = document.getElementById('assign-issue')
issueEditor.on('text-change', function(params) {
    let htmlText = issueEditor.root.innerHTML
    issueContent.innerHTML = htmlText
})

// copy cost text into html only text area from quill editor
let costContent = document.getElementById('assign-cost')
costEditor.on('text-change', function(params) {
    let htmlText = costEditor.root.innerHTML
    costContent.innerHTML = htmlText
})