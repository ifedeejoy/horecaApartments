window.getElByThis = function(arg) {
    let id = arg.getAttribute('id')
    let idNo = id.match(/\d+/g)
    let idValue = arg.value
    let idParams = { "idNo": idNo, "id": id, "value": idValue }
    return idParams
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
        '<input type="hidden" name="status[]" value="reserved">' +
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
        departureDate = formatDate.add(nights, 'days').format("YYYY-MM-DD hh:mm")
    console.log(price)
    console.log(finalPrice)
    $("#departure" + idNo).val(departureDate)
    $("#apartment-cost" + idNo).val(finalPrice)
}

window.togglePayment = function(val) {
    if (val != 'no payment') {
        $("#pm-container").removeClass('d-none')
        $("#dp-container").removeClass('d-none')
        $("#gd-container").removeClass('d-none')
        $("#ip-container > .form-group").removeClass('col-md-6')
        $("#ip-container > .form-group").addClass('col-md-4')
    } else if (val == 'no payment') {
        $("#pm-container").addClass('d-none')
        $("#dp-container").addClass('d-none')
        $("#gd-container").addClass('d-none')
        $("#ip-container > .form-group").addClass('col-md-6')
    }
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
        discount = $("#discount").val(),
        deposit = $("#deposit").val(),
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