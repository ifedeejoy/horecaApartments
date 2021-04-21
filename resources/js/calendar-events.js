/**
 * App Calendar Events
 */

'use strict';
let moment = require('moment')
var date = new Date();
var nextDay = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
// prettier-ignore
var nextMonth = date.getMonth() === 11 ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() + 1, 1);
// prettier-ignore
var prevMonth = date.getMonth() === 11 ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() - 1, 1);

let makeEvents = new Array
    // fetch reservation data
var getReservations = $.ajax({
        url: '/api/calendar',
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function(data) {
            return data
        }
    }).responseText
    // fetch google calendar data
var googleCalendar = $.ajax({
        url: '/front-desk/events',
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function(data) {
            return data
        },
        error: function(error) {
            console.log(error);
        }
    }).responseText
    // parse and format reservation data
let jsonResult = JSON.parse(getReservations)
let reservations = jsonResult.reservations
reservations.forEach(reservation => {
        let guest = reservation.guest
        let apartment = reservation.apartments
        let calendar = reservation.status == 'reserved' ? 'reserved' : 'inhouse'
        makeEvents.push({
            id: reservation.id,
            url: '/front-desk/reservation' + reservation.id,
            title: guest.title + ' ' + guest.name + ' (' + apartment.name + ')',
            start: moment(reservation.checkin).format(),
            end: moment(reservation.checkout).format(),
            allDay: true,
            extendedProps: {
                calendar: calendar
            }
        })
    })
    // parse and format google calendar data
let gcalJson = JSON.parse(googleCalendar)
let googleEvents = gcalJson.data
if (googleEvents.length > 0) {
    googleEvents.forEach(googleEvents => {
        let allDay = googleEvents.allDay == 1 ? true : false
        makeEvents.push({
            id: googleEvents.calendar_id,
            title: googleEvents.name,
            start: moment(googleEvents.started_at).format(),
            end: moment(googleEvents.ended_at).format(),
            allDay: allDay,
            extendedProps: {
                calendar: 'googlecalendar'
            }
        })

    })
}

var events = makeEvents

export { events }