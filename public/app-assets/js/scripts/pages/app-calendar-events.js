/**
 * App Calendar Events
 */

'use strict';

var date = new Date();
var nextDay = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
// prettier-ignore
var nextMonth = date.getMonth() === 11 ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() + 1, 1);
// prettier-ignore
var prevMonth = date.getMonth() === 11 ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() - 1, 1);

let makeEvents = new Array

var getReservations = $.ajax({
    url: '/api/calendar',
    type: 'GET',
    dataType: 'json',
    async: false,
    success: function(data) {
        return data
    }
}).responseText
let jsonResult = JSON.parse(getReservations)
let reservations = jsonResult.reservations
reservations.forEach(reservation => {
    let guest = reservation.guest
    let apartment = reservation.apartments
    makeEvents.push({
        id: reservation.id,
        url: '/front-desk/reservation' + reservation.id,
        title: guest.title + ' ' + guest.name + ' (' + apartment.name + ')',
        start: new Date(moment(reservation.checkin).format()),
        end: new Date(moment(reservation.checkout).format()),
        allDay: true,
        extendedProps: {
            calendar: apartment.name
        }
    })
})

var events = makeEvents