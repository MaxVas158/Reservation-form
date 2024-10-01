document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'cs',
    navLinks: true,

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },
    timeFormat: 'h(:mm)',
    showNonCurrentDates: false,
    buttonText: {
      today: 'Dnes',
      month: 'Měsíc',
      week: 'Týden',
      day: 'Den',
      list: 'Seznam'
    },
    titleFormat: {
      month: 'short',
      year: 'numeric',
    },
    slotLabelFormat: {
      hour: 'numeric',
      minute: '2-digit',
      omitZeroMinute: false,
      meridiem: false,
    },
    eventTimeFormat: {
      hour: 'numeric',
      minute: '2-digit',
      meridiem: false
    },
    allDayText: 'Celý den',

   

  });
  calendar.render();
});


