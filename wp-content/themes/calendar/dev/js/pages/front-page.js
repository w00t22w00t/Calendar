$(function () {
  // calendar
  var calendarEl = document.getElementById("calendar");

  function getCurrentDate() {
    var today = new Date();

    var year = today.getFullYear();
    var month = (today.getMonth() + 1).toString().padStart(2, "0");
    var day = today.getDate().toString().padStart(2, "0");

    var formattedDate = year + "-" + month + "-" + day;
    return formattedDate;
  }

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    initialDate: getCurrentDate(),
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
    events: events,
    eventClick: function (event) {
      getInfo(event.event._def.extendedProps.post_id);
    },
  });

  function getInfo(id) {
    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: "load_modal_info",
        id: id,
      },
      success: function (data) {
        $("body").addClass("modal-open");
        if (data) {
          $(".modal__content").html(data);
        } else {
          $(".modal__content").html("Виникла помилка");
        }
      },
    });
  }

  calendar.render();

  // form
  const $name = $("#name");
  const $email = $("#email");
  const $phone = $("#phone");

  $(".modal__overlay").on("click", function (e) {
    if (
      e.target === $(".modal__overlay")[0] ||
      e.target === $(".modal__close")[0]
    ) {
      $("body").removeClass("modal-open");
    }
  });

  $("#form").on("submit", function (event) {
    event.preventDefault();

    const formId = $(".modal__title").attr("data-id");
    const isValid = validateForm();

    if (isValid) {
      const data = {
        id: formId,
        name: $name.val(),
        email: $email.val(),
        phone: $phone.val(),
      };

      sendLead(data);
    }
  });

  function validateForm() {
    let isValid = true;

    // Check if name is filled
    if ($name.val() <= 2) {
      console.log($("#label-name"));
      $("#label-name").addClass("error");
      isValid = false;
    } else {
      $("#label-name").removeClass("error"); // Reset error
    }

    // Check email
    if (!isValidEmail($email.val())) {
      $("#label-email").addClass("error");
      isValid = false;
    } else {
      $("#label-email").removeClass("error"); // Reset error
    }

    // Check phone
    if (!validatePhone($phone.val())) {
      $("#label-phone").addClass("error");
      isValid = false;
    } else {
      $("#label-phone").removeClass("error"); // Reset error
    }

    return isValid;
  }

  function isValidEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
  }

  function validatePhone(phone) {
    var phoneRegex = /^[+\d\s()-]{10,20}$/;

    if (phoneRegex.test(phone)) {
      return true;
    } else {
      return false;
    }
  }

  function sendLead(data) {
    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: "leads_form",
        id: data.id,
        name: data.name,
        email: data.email,
        phone: data.phone,
      },
      success: function (data) {
        $("body").removeClass("modal-open");
        $("#form input").val("");

        console.log(data);
      },
    });
  }
});
