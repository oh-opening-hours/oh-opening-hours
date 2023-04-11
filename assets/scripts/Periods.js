jQuery(function($) {
  $.fn.opPeriodsDay = function() {
    return this.each(function(index, element) {
      var wrap = $(element);

      var periodContainer = wrap.find(".period-container");
      var tbody = periodContainer.find("div.row-wrap");
      var btnAddPeriod = wrap.find("a.add-period");

      function addPeriod() {
        var data = {
          action: "opoh_render_single_period",
          weekday: periodContainer.attr("data-day"),
          set: periodContainer.attr("data-set")
        };

        $.post(ajax_object.ajax_url, data, function(response) {
          var newPeriod = $(response).clone();
          newPeriod.opSinglePeriod();
          tbody.append(newPeriod);
        });
      }

      btnAddPeriod.click(function() {
        addPeriod();
      });
    });
  };

  $.fn.opSinglePeriod = function() {
    return this.each(function(index, element) {
      var wrap = $(element);

      var btnDeletePeriod = wrap.find(".delete-period");
      var inputTimeStart = wrap.find(".input-time-start");
      var inputTimeEnd = wrap.find(".input-time-end");
    
      inputTimeStart.flatpickr({
        enableTime: true,
        time_24hr: true,
        noCalendar: true,
        dateFormat: "H:i"
      });
    
      inputTimeEnd.flatpickr({
        enableTime: true,
        time_24hr: true,
        noCalendar: true,
        dateFormat: "H:i"
      });
      

      btnDeletePeriod.click(function() {
        wrap.remove();
      });

    });
  };

  $(document).ready(function() {
    var form = $(".form-opening-hours");
    form.find("div.periods-day").opPeriodsDay();
    form.find("div.period").opSinglePeriod();
  });
});
