$("#maintenance-list-table").DataTable({
    dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
        '<"col-lg-12 col-xl-3" l>' +
        '<"col-lg-12 col-xl-9 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
        '>t' +
        '<"d-flex justify-content-between mx-2 row mb-1"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
    order: [
        [5, 'desc']
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
$("#edit-apartment").select2({
    placeholder: 'Select Apartment'
})
$("#issue-apartment").select2({
    placeholder: 'Select Apartment'
})
$("#vendor-search").select2({
    placeholder: 'Select Vendor'
})
$("#issue-vendor").select2({
    placeholder: 'Select Vendor'
})
$("#issue-status").select2({
    placeholder: 'Select Status'
})

$("#assign-apartment").select2({
    placeholder: 'Select Apartment'
})
$("#select-vendor").select2({
    placeholder: 'Select Vendor'
})
$("#edit-vendor").select2({
    placeholder: 'Select Vendor'
})
$("#payment-method").select2()
$("#edit-payment-method").select2()
$("#update-payment-method").select2({
    placeholder: 'Select payment method'
})


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

let editIssueEditor = new Quill('#edit-issue-editor', {
    placeholder: 'Issue',
    theme: 'snow'
})

let editCostEditor = new Quill('#edit-cost-editor', {
    placeholder: 'Cost Breakdown',
    theme: 'snow'
})

let updateIssueEditor = new Quill('#update-issue-editor', {
    readOnly: true,
    theme: 'snow'
})

let updateBreakdownEditor = new Quill('#update-cost-editor', {
    theme: 'snow'
})

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

// copy edit issue text into html only text area from quill editor
let editIssueContent = document.getElementById('edit-issue-text')
editIssueEditor.on('text-change', function(params) {
    let htmlText = editIssueEditor.root.innerHTML
    editIssueContent.innerHTML = htmlText
})

// copy edit cost text into html only text area from quill editor
let editCostContent = document.getElementById('edit-cost-breakdown')
editCostEditor.on('text-change', function(params) {
    let htmlText = editCostEditor.root.innerHTML
    editCostContent.innerHTML = htmlText
})

// copy update cost breakdown text into html only text area from quill editor
let updateBreakdownContent = document.getElementById('update-cost-breakdown')
updateBreakdownEditor.on('text-change', function(params) {
    let htmlText = updateBreakdownEditor.root.innerHTML
    updateBreakdownContent.innerHTML = htmlText
})

//modal functions
window.assignVendor = function(apartment) {
    $("#edit-issue-form")[0].reset()
    let apartmentId = apartment[0]
    let apartmentName = apartment[1]
    let apartmentIssue = apartment[2]
    let issue = apartment[3]
    $("#issue_id").val(issue)
    $("#assign-apartment").append("<option value='" + apartmentId + "' selected>" + apartmentName + "</option>")
    let content = apartmentIssue
    issueEditor.clipboard.dangerouslyPasteHTML(content)
}

window.editIssue = function(issue) {
    $.ajax({
            url: '/api/maintenance/issue/' + issue,
            method: 'GET',
            dataType: 'json',
            cache: false,
        }).fail(function(jqXHR) {
            console.log(jqXHR.responseText)
        })
        .done(function(data) {
            $("#edit-issue-form")[0].reset()
            let issue = data.data[0]
            let vendor = issue.vendor_id == null ? "" : "<option value='" + issue.vendor_id + "' selected>" + issue.vendor.name + "</option>"
            let payment = issue.last_payment.length == 0 ? null : issue.last_payment[0]
            let cost = payment == null ? "" : payment.cost
            let paid = payment == null ? "" : payment.paid
            let paymentMethod = payment == null ? "" : "<option value='" + payment.payment_method + "' selected>" + payment.payment_method + "</option>"
            $("#edited_issue").val(issue.id)
            $("#edit-apartment").append("<option value='" + issue.apartments_id + "' selected>" + issue.apartment.name + "</option>")
            $("#edit-vendor").append(vendor)
            $("#edited-issue").val(issue.id)
            $("#edit-cost").val(cost)
            $("#edit-paid").val(paid)
            $("#edit-payment-method").append(paymentMethod)
            let issueContent = issue.issue
            editIssueEditor.clipboard.dangerouslyPasteHTML(issueContent)
            let costContent = payment == null ? "" : payment.cost_breakdown
            editCostEditor.clipboard.dangerouslyPasteHTML(costContent)
        })
}

window.updateIssue = function(issue) {
    $.ajax({
            url: '/api/maintenance/issue/' + issue,
            method: 'GET',
            dataType: 'json',
            cache: false,
        }).fail(function(jqXHR) {
            console.log(jqXHR.responseText)
        })
        .done(function(data) {
            $("#update-issue-form")[0].reset()
            let issue = data.data[0]
            let vendor = issue.vendor_id == null ? "" : "<option value='" + issue.vendor_id + "' selected>" + issue.vendor.name + "</option>"
            let payment = issue.last_payment.length == 0 ? null : issue.last_payment[0]
            let cost = payment == null ? "" : payment.cost
            let paid = payment == null ? "" : payment.paid
            let balance = payment == null ? "" : payment.balance
            $("#updated-issue").val(issue.id)
            $("#issue-apartment").append("<option value='" + issue.apartments_id + "' selected>" + issue.apartment.name + "</option>")
            $("#issue-status").append("<option value='" + issue.status + "' selected>" + issue.status + "</option>")
            $("#issue-vendor").append(vendor)
            $("#update-cost").val(cost)
            $("#update-prev-paid").val(paid)
            $("#update-balance").val(balance)
            let issueContent = issue.issue
            updateIssueEditor.clipboard.dangerouslyPasteHTML(issueContent)
            let costContent = payment == null ? "" : payment.cost_breakdown
            updateBreakdownEditor.clipboard.dangerouslyPasteHTML(costContent)
        })
}