function deleteRate(rate) {
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
                text: data.message
            })
            setTimeout(function() {
                window.location.reload()
            }, 3000)
        },
        error: function(data) {
            console.log(data);
        }
    })
}

function checkinGuest(reservation) {
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
                text: data.message
            })
            setTimeout(function() {
                window.open(data.url, '_self')
            }, 3000)
        },
        error: function(data) {
            console.log(data);
        }
    })
}