jQuery(function($) {
  $(document).ready(function() {
    var dateStart = $(".op-criteria-date-start");
    var dateEnd = $(".op-criteria-date-end");

    dateStart.addClass("input-gray");
    dateEnd.addClass("input-gray");

    dateStart.flatpickr({
      dateFormat: "Y-m-d",
      onChange: function (selectedDates, dateStr, instance) {
        dateEnd.flatpickr().set("minDate", dateStr);
      }
    });

    dateEnd.flatpickr({
      dateFormat: "Y-m-d",
      onChange: function (selectedDates, dateStr, instance) {
        dateStart.flatpickr().set("maxDate", dateStr);
      }
    });


    $("#op-set-detail-child-set-notice")
      .parents(".field")
      .hide();
  });
});
