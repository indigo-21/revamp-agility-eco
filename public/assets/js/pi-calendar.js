$(function () {

    $.ajax({
        url: '/make-booking/getBookedJobs',
        type: 'GET',
        dataType: 'json',
        data: {
            property_inspector_id: $("#calendar").data('id')
        },
        success: function (data) {
            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');


            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                //Random default events
                events: data,
            });

            calendar.render();
        },
        error: function (xhr, status, error) {
            console.error('Error fetching booked jobs:', error);
        }
    });
})