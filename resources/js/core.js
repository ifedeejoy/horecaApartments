import lightbox from 'lightbox2'

lightbox.option({
    'alwaysShowNavOnTouchDevices': true,
    'wrapAround': true
})

window.getElByThis = function(arg) {
    let id = arg.getAttribute('id')
    let idNo = id.match(/\d+/g)
    let idValue = arg.value
    let idParams = { "idNo": idNo, "id": id, "value": idValue }
    return idParams
}

function getUrl(url) {
    var parser = document.createElement('a')
    parser.href = url
    return parser.pathname
}

window.deleteRate = function(rate) {
    let formData = { rate: rate, _method: 'DELETE' }
    $.ajax({
        url: '/admin/rates/' + rate,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        dataType: 'json',
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 300,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            }).then(function() {
                window.location.reload()
            })
        },
        error: function(data) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message,
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false
            }).then(function() {
                window.location.reload()
            })
        }
    })
}

window.checkinGuest = function(reservation) {
    let formData = { reservation: reservation, _method: "PUT" }
    $.ajax({
        url: '/checkin-guest/' + reservation,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        dataType: 'json',
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            }).then(function() {
                window.location.reload()
            })
        },
        error: function(data) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message,
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false
            }).then(function() {
                window.location.reload()
            })
        }
    })
}

window.guestInfo = function(id) {
    $.ajax({
        url: '/api/guest/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            let guest = data.data[0]
            $("#title").val(guest.title)
            $("#title").select2().trigger('change')
            $("#name").val(guest.name)
            $("#title").val(guest.title)
            $("#phone").val(guest.phone)
            $("#email").val(guest.email)
            $("#address").val(guest.address)
        },
        error: function(data) {
            toastr.error(data.statusText, '👋 Alert', {
                progressBar: true,
                closeButton: true,
                tapToDismiss: false
            })
        }
    })
}

window.apartmentInfo = function(apartment, elId) {
    $.ajax({
        url: '/api/rates/' + apartment,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            let apartment = data.data
            let rates, max_guests
            apartment.forEach((value) => {
                rates = value.rates
                max_guests = value.max_guests
            })
            let options = new Array();
            let el = isNaN(elId) ? "#rates" : "#rates" + elId
            let occupant = isNaN(elId) ? "#occupants" : "#occupants" + elId

            for (let i = 0; i < rates.length; i++) {
                options.push({
                    "id": rates[i].id,
                    "text": rates[i].name,
                    "amount": rates[i].amount
                })
            }
            $(el + " option").remove()
            $(el).append(new Option(' ', ' '))
            $(el).select2({
                data: options
            })
            $(occupant).trigger('touchspin.updatesettings', { max: max_guests })
        },
        error: function(data) {
            console.log(data)
            toastr.error(data.statusText, '👋 Alert', {
                progressBar: true,
                closeButton: true,
                tapToDismiss: false
            })
        }
    })
}

let elId = 1
window.addRooms = function() {
    elId++
    let currentUrl = getUrl(window.location.href)
    let resStatus = currentUrl == "/front-desk/new-reservation" ? "reserved" : 'checkedin'
    $("#rooms-section").append(
        '<div class="rooms" id="extra-room' + elId + '">' +
        '<hr class="my-1">' +
        '<div class="d-flex justify-content-end">' +
        '<button class="btn-icon btn btn-danger btn-round btn-sm" type="button" onclick="removeRoom(' + elId + ')">X</button>' +
        '</div>' +
        '<div class="row mb-2">' +
        '<div class="form-group col-md-6">' +
        '<label class="form-label" for="apartment">Apartment</label>' +
        '<select class="select2 w-100" id="apartment' + elId + '" name="apartment[]"  onchange="apartmentInfo(this.value, ' + elId + ')">' +
        '<option label=" "></option>' +
        '</select>' +
        '</div>' +
        '<div class="form-group col-md-6">' +
        '<label class="form-label" for="rates">Rate</label>' +
        '<select class="select2 w-100" name="rates[]" id="rates' + elId + '" onchange="ratePrice(' + elId + ')"> ' +
        '<option label=" "></option>' +
        '</select>' +
        '</div>' +
        '<input type="hidden" name="rate-price[]" id="rate-price' + elId + '">' +
        '<input type="hidden" class="prices" name="apartment-cost[]" id="apartment-cost' + elId + '">' +
        '<input type="hidden" name="status[]" value="' + resStatus + '">' +
        '</div>' +
        '<div class="row mb-2">' +
        '<div class="form-group col-md-6">' +
        '<label class="form-label" for="arrival">Arrival Date/Time</label>' +
        '<input type="text" id="arrival' + elId + '" name="arrival[]" class="form-control" placeholder="13-12-2020 2:00 PM" />' +
        '</div>' +
        '<div class="input-group col-md-6">' +
        '<label class="form-label" for="nights">Night(s)</label>' +
        '<input type="text" id="nights' + elId + '" name="nights[]" class="touchspin nights input-group-lg" value="{number}" onkeyup="departureDate(this)"/>' +
        '</div>' +
        '</div>' +
        '<div class="row mb-2">' +
        '<div class="form-group col-md-6">' +
        '<label class="form-label" for="departure">Departure Date/Time</label>' +
        '<input type="text" id="departure' + elId + '" name="departure[]" class="form-control" placeholder="15-12-2020 2:00 PM" />' +
        '</div>' +
        '<div class="input-group col-md-6">' +
        '<label class="form-label" for="occupants">Occupant(s)</label>' +
        '<input type="text" id="occupants' + elId + '" name="occupants[]" class="touchspin input-group-lg" value="{number}" />' +
        '</div>' +
        '</div>' +

        '<div class="row mb-2">' +
        '<div class="col-md-12">' +
        '<div class="form-label-group mb-0">' +
        '<textarea data-length="200" class="form-control char-textarea" name="extras[]" id="notes' + elId + '" rows="2" placeholder="Additional information"></textarea>' +
        '<label for="notes">Notes</label>' +
        '</div>' +
        '<small class="textarea-counter-value float-right"><span class="char-count">0</span> / 200 </small>' +
        '</div>' +
        '</div>' +
        '</div>'
    )
    $('#apartment' + elId).html($('#apartment').html())
    $('#arrival' + elId).flatpickr({
        enableTime: true,
    })
    $('.touchspin').TouchSpin({
        buttondown_class: 'btn btn-primary',
        buttonup_class: 'btn btn-primary',
        buttondown_txt: feather.icons['minus'].toSvg(),
        buttonup_txt: feather.icons['plus'].toSvg()
    })
    $("#apartment" + elId).select2({
        placeholder: 'Select Apartment'
    })
    $("#rates" + elId).select2({
        placeholder: 'Select Rate'
    })
    $(".nights").on("change", function(event) {
        departureDate(this)
    })
}

window.ratePrice = function(elId) {
    let el = isNaN(elId) ? "#rates" : "#rates" + elId
    let elRP = isNaN(elId) ? "#rate-price" : "#rate-price" + elId
    $(el).on('select2:select', function(e) {
        let data = e.params.data
        $(elRP).val(data.amount)
    })
}

window.removeRoom = function(id) {
    $("#extra-room" + id).remove()
}

window.departureDate = function(arg) {
    let moment = require('moment')
    let args = getElByThis(arg)
    let nights = args.value,
        elId = args.id,
        idNo = args.idNo == null ? "" : args.idNo,
        arrival = $("#arrival" + idNo).val(),
        price = $("#rate-price" + idNo).val(),
        finalPrice = price * nights,
        formatDate = moment(arrival, "YYYY-MM-DD hh:mm"),
        departureDate = formatDate.add(nights, 'days').format("YYYY-MM-DD hh:mm"),
        apartment = $("#apartment" + idNo).val()
    $.ajax({
        url: '/api/availability',
        method: 'POST',
        data: { 'start': arrival, 'end': departureDate, 'apartment': apartment },
        dataType: 'json',
        success: function(data) {
            console.log(data)
            if (jQuery.isEmptyObject(data.data)) {
                $("#departure" + idNo).val(departureDate)
                $("#apartment-cost" + idNo).val(finalPrice)
            } else {
                let checkin = data.data.checkin
                let checkout = data.data.checkout == null ? departureDate : data.data.checkout
                let suggestedNights = data.data.nights == null ? nights : data.data.nights
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Apartment is not available for selected duration, set checkin date to ' + checkin + ' and checkout date to ' + checkout + ' the apartment is available for ' + suggestedNights + ' night(s)',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
            }
        },
        error: function(data) {
            console.log(data)
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data,
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
        }
    })

}

window.togglePayment = function(val) {
    if (val != 'none') {
        $("#pm-container").removeClass('d-none')
        $("#dp-container").removeClass('d-none')
        $("#gd-container").removeClass('d-none')
        $("#ip-container > .form-group").removeClass('col-md-6')
        $("#ip-container > .form-group").addClass('col-md-4')
    } else if (val == 'none') {
        $("#pm-container").addClass('d-none')
        $("#dp-container").addClass('d-none')
        $("#gd-container").addClass('d-none')
        $("#ip-container > .form-group").addClass('col-md-6')

    }
    getTotals()
}

window.toggleDiscount = function(val) {
    if (val == 'no') {
        $("#discount").val("0")
        $("#discount-reason").val("no discount given")
        let subtotal = document.getElementById('subtotal')
        if (subtotal.value.length > 0 && parseInt(subtotal.value) > 1) {
            getTotals()
        }
    } else {
        $("#discount").val("")
        $("#discount-reason").val("")
    }
}

window.toggleDeposit = function(val) {
    if (val == 'no') {
        $('#deposit').val("0")
    } else {
        $('#deposit').val("0")
    }
}

window.getTotals = function() {
    let prices = 0,
        discount = isNaN($("#discount").val()) ? 0 : $("#discount").val(),
        deposit = isNaN($("#deposit").val()) ? 0 : $("#deposit").val(),
        balance,
        total
    $('.prices').each(function() {
        prices += parseInt(this.value)
    })
    total = prices
    prices -= discount
    balance = prices - deposit
    $("#subtotal").val(total.toLocaleString('en-US'))
    $("#balance").val(balance.toLocaleString('en-US'))
    $("#total").val(prices.toLocaleString('en-US'))
}

window.billPaymentOptions = function(option) {
    if (option == 'Instant') {
        $("#payment-method").attr('required', 'required')
        $(".payment-div").removeClass('d-none')
    } else if (option == 'At Checkout') {
        $("#payment-method").removeAttr('required')
        $(".payment-div").addClass('d-none')
    }
}

window.typeOptions = function(val) {
    if (val == 'upgrade') {
        $("#balances").removeClass('d-none')
        $("#balance").removeAttr('disabled')
        $("#reasons").addClass('d-none')
        $("#reason").attr('disabled', 'disabled')
    } else if (val == 'switch') {
        $("#reasons").removeClass('d-none')
        $("#reason").removeAttr('disabled')
        $("#balances").addClass('d-none')
        $("#balance").attr('disabled', 'disabled')
    }
}

window.selectVendor = function(val) {
    if (val == 0) {
        $('.vendor-info').removeAttr('disabled')
        $('.vendor-info').removeClass('d-none')
        $('.vendor-group').removeClass('d-none')
    } else {
        $('.vendor-info').attr('disabled')
        $('.vendor-info').addClass('d-none')
        $('.vendor-group').addClass('d-none')
    }
}

export { getUrl }