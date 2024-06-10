"use strict";

var customEvents = [];

// Class definition
var KTAppCalendar = function () {
    // Shared variables
    // Calendar variables
    var calendar;
    var data = {
        id: '',
        eventName: '',
        eventDescription: '',
        eventLocation: '',
        startDate: '',
        endDate: '',
        allDay: false
    };

    // Add event variables
    var eventName;
    var eventDescription;
    var eventLocation;
    var startDatepicker;
    var startFlatpickr;
    var endDatepicker;
    var endFlatpickr;
    var startTimepicker;
    var startTimeFlatpickr;
    var endTimepicker
    var endTimeFlatpickr;
    var modal;
    var modalTitle;
    var form;
    var validator;
    var addButton;
    var submitButton;
    var cancelButton;
    var closeButton;

    // View event variables
    var viewEventName;
    var viewAllDay;
    var viewEventDescription;
    var viewEventLocation;
    var viewStartDate;
    var viewEndDate;
    var viewModal;
    var viewEditButton;

    var getProjectDate = function () {
        jQuery.ajax({
        url: projectBaseUrl+'/calendar',
        type: 'GET',
        dataType: 'json', 
        success: function (doc) {
            customEvents = doc;
            initCalendarApp();
            initValidator();
            initDatepickers();
            handleEditButton();
            handleCloseButton();
        },
        error: function (xhr) {
            alert("readyState: " + '/calender' + "\nstatus: " + xhr.status);
        }
    })};

    // Private functions
    var initCalendarApp = function () {
        var calendarEl = document.getElementById('kt_calendar_app');
        var todayDate = moment().startOf('day');
        var TODAY = todayDate.format('YYYY-MM-DD');

        // Init calendar --- more info: https://fullcalendar.io/docs/initialize-globals
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            initialDate: TODAY,
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,

            // Select dates action --- more info: https://fullcalendar.io/docs/select-callback
            select: function (arg) {
                formatArgs(arg);
            },

            // Click event --- more info: https://fullcalendar.io/docs/eventClick
            eventClick: function (arg) {
                formatArgs({
                    id: arg.event.id,
                    title: arg.event.title,
                    description: arg.event.extendedProps.description,
                    location: arg.event.extendedProps.location,
                    startStr: arg.event.startStr,
                    endStr: arg.event.endStr,
                    allDay: arg.event.allDay
                });
                
                $.post(projectBaseUrl+'/calender/project/info',{"pID":arg.event.id,"_token":token},function(data){
                     let pOpen = (data.project.opening == 1) ? "نعم" : "لا";
                     let pOpenHall = (data.project.opening_reserve_hall == 1) ? "نعم" : "لا";
                     let pOpenAttend = (data.project.opening_attendance_nature == "regulars") ? "عاديين" : "قادة";
                     let pClose = (data.project.closing == 1) ? "نعم" : "لا";
                     let pCloseHall = (data.project.closing_reserve_hall == 1) ? "نعم" : "لا";
                     let pCloseAttend = (data.project.closing_attendance_nature == "regulars") ? "عاديين" : "قادة";
                    $('[data-kt-calendar="project-type"]').html(data.project.type.title);
                    $('[data-kt-calendar="project-area"]').html(data.regions);
                    $('[data-kt-calendar="project-startDate"]').html(data.project.start_date);
                    $('[data-kt-calendar="project-endDate"]').html(data.project.end_date);
                    $('[data-kt-calendar="project-cases"]').html(data.project.cases_count);
                    $('[data-kt-calendar="project-buildings"]').html(data.project.building_count);
                    $('[data-kt-calendar="project-open"]').html(pOpen);
                    $('[data-kt-calendar="project-openHall"]').html(pOpenHall);
                    $('[data-kt-calendar="project-openAttend"]').html(pOpenAttend);
                    $('[data-kt-calendar="project-openDate"]').html(data.project.opening_date);
                    $('[data-kt-calendar="project-close"]').html(pClose);
                    $('[data-kt-calendar="project-closeHall"]').html(pCloseHall);
                    $('[data-kt-calendar="project-closeAttend"]').html(pCloseAttend);
                    $('[data-kt-calendar="project-closeDate"]').html(data.project.closing_date);
                    $('img.ico').attr({"src":mediaUrl+"pdf.svg"});
                    $('a#rfp').attr({"href":fileUrl+data.project.rfp});
                    $('a#req').attr({"href":fileUrl+data.project.requirements_specifications});
                    $('a#addQ').attr({"href":fileUrl+data.project.additional_questions});
                    $('a#maps').attr({"href":fileUrl+data.project.google_map});
                });
                
                handleViewEvent();
            },

            editable: true,
            dayMaxEvents: true, // allow "more" link when too many events
            events: customEvents,
            // Handle changing calendar views --- more info: https://fullcalendar.io/docs/datesSet
            datesSet: function(){
                // do some stuff
            }
        }); 
        calendar.render();
    }

    // Init validator
    const initValidator = () => {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'calendar_event_name': {
                        validators: {
                            notEmpty: {
                                message: 'Event name is required'
                            }
                        }
                    },
                    'calendar_event_start_date': {
                        validators: {
                            notEmpty: {
                                message: 'Start date is required'
                            }
                        }
                    },
                    'calendar_event_end_date': {
                        validators: {
                            notEmpty: {
                                message: 'End date is required'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );
    }

    // Initialize datepickers --- more info: https://flatpickr.js.org/
    const initDatepickers = () => {
        startFlatpickr = flatpickr(startDatepicker, {
            enableTime: false,
            dateFormat: "Y-m-d",
        });

        endFlatpickr = flatpickr(endDatepicker, {
            enableTime: false,
            dateFormat: "Y-m-d",
        });

        startTimeFlatpickr = flatpickr(startTimepicker, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });

        endTimeFlatpickr = flatpickr(endTimepicker, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
    }

    // Handle edit event
    const handleEditEvent = () => {
        // Update modal title
        modalTitle.innerText = "Edit an Event";

        modal.show();

        // Select datepicker wrapper elements
        const datepickerWrappers = form.querySelectorAll('[data-kt-calendar="datepicker"]');

        // Handle all day toggle
        const allDayToggle = form.querySelector('#kt_calendar_datepicker_allday');
        allDayToggle.addEventListener('click', e => {
            if (e.target.checked) {
                datepickerWrappers.forEach(dw => {
                    dw.classList.add('d-none');
                });
            } else {
                endFlatpickr.setDate(data.startDate, true, 'Y-m-d');
                datepickerWrappers.forEach(dw => {
                    dw.classList.remove('d-none');
                });
            }
        });

        populateForm(data);

        // Handle submit form
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable submit button whilst loading
                        submitButton.disabled = true;

                        // Simulate form submission
                        setTimeout(function () {
                            // Simulate form submission
                            submitButton.removeAttribute('data-kt-indicator');

                            // Show popup confirmation 
                            Swal.fire({
                                text: "New event added to calendar!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    modal.hide();

                                    // Enable submit button after loading
                                    submitButton.disabled = false;

                                    // Remove old event
                                    calendar.getEventById(data.id).remove();

                                    // Detect if is all day event
                                    let allDayEvent = false;
                                    if (allDayToggle.checked) { allDayEvent = true; }
                                    if (startTimeFlatpickr.selectedDates.length === 0) { allDayEvent = true; }

                                    // Merge date & time
                                    var startDateTime = moment(startFlatpickr.selectedDates[0]).format();
                                    var endDateTime = moment(endFlatpickr.selectedDates[endFlatpickr.selectedDates.length - 1]).format();
                                    if (!allDayEvent) {
                                        const startDate = moment(startFlatpickr.selectedDates[0]).format('YYYY-MM-DD');
                                        const endDate = startDate;
                                        const startTime = moment(startTimeFlatpickr.selectedDates[0]).format('HH:mm:ss');
                                        const endTime = moment(endTimeFlatpickr.selectedDates[0]).format('HH:mm:ss');

                                        startDateTime = startDate + 'T' + startTime;
                                        endDateTime = endDate + 'T' + endTime;
                                    }

                                    // Add new event to calendar
                                    calendar.addEvent({
                                        id: uid(),
                                        title: eventName.value,
                                        description: eventDescription.value,
                                        location: eventLocation.value,
                                        start: startDateTime,
                                        end: endDateTime,
                                        allDay: allDayEvent
                                    });
                                    calendar.render();

                                    // Reset form for demo purposes only
                                    form.reset();
                                }
                            });

                            //form.submit(); // Submit form
                        }, 2000);
                    } else {
                        // Show popup warning 
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });
    }

    // Handle view event
    const handleViewEvent = () => {
        viewModal.show();

        // Detect all day event
        var eventNameMod;
        var startDateMod;
        var endDateMod;

        // Generate labels
        if (data.allDay) {
            eventNameMod = 'All Day';
            startDateMod = moment(data.startDate).format('Do MMM, YYYY');
            endDateMod = moment(data.endDate).format('Do MMM, YYYY');
        } else {
            eventNameMod = '';
            startDateMod = moment(data.startDate).format('Do MMM, YYYY - h:mm a');
            endDateMod = moment(data.endDate).format('Do MMM, YYYY - h:mm a');
        }

        // Populate view data
        viewEventName.innerText = data.eventName;
        viewAllDay.innerText = eventNameMod;
        viewEventDescription.innerText = data.eventDescription ? data.eventDescription : '--';
        viewEventLocation.innerText = data.eventLocation ? data.eventLocation : '--';
        viewStartDate.innerText = startDateMod;
        viewEndDate.innerText = endDateMod;
    }

    // Handle edit button
    const handleEditButton = () => {
        viewEditButton.addEventListener('click', e => {
            e.preventDefault();

            viewModal.hide();
            handleEditEvent();
        });
    }

    // Handle close button
    const handleCloseButton = () => {
        // Edit event modal close button
        closeButton.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form	
                    modal.hide(); // Hide modal				
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });
    }

    // Handle view button
    const handleViewButton = () => {
        const viewButton = document.querySelector('#kt_calendar_event_view_button');
        viewButton.addEventListener('click', e => {
            e.preventDefault();

            hidePopovers();
            handleViewEvent();
        });
    }

    // Helper functions

    // Populate form 
    const populateForm = () => {
        eventName.value = data.eventName ? data.eventName : '';
        eventDescription.value = data.eventDescription ? data.eventDescription : '';
        eventLocation.value = data.eventLocation ? data.eventLocation : '';
        startFlatpickr.setDate(data.startDate, true, 'Y-m-d');

        // Handle null end dates
        const endDate = data.endDate ? data.endDate : moment(data.startDate).format();
        endFlatpickr.setDate(endDate, true, 'Y-m-d');

        const allDayToggle = form.querySelector('#kt_calendar_datepicker_allday');
        const datepickerWrappers = form.querySelectorAll('[data-kt-calendar="datepicker"]');
        if (data.allDay) {
            allDayToggle.checked = true;
            datepickerWrappers.forEach(dw => {
                dw.classList.add('d-none');
            });
        } else {
            startTimeFlatpickr.setDate(data.startDate, true, 'Y-m-d H:i');
            endTimeFlatpickr.setDate(data.endDate, true, 'Y-m-d H:i');
            endFlatpickr.setDate(data.startDate, true, 'Y-m-d');
            allDayToggle.checked = false;
            datepickerWrappers.forEach(dw => {
                dw.classList.remove('d-none');
            });
        }
    }

    // Format FullCalendar reponses
    const formatArgs = (res) => {
        data.id = res.id;
        data.eventName = res.title;
        data.eventDescription = res.description;
        data.eventLocation = res.location;
        data.startDate = res.startStr;
        data.endDate = res.endStr;
        data.allDay = res.allDay;
    }

    // Generate unique IDs for events
    const uid = () => {
        return Date.now().toString() + Math.floor(Math.random() * 1000).toString();
    }

    return {
        // Public Functions
        init: function () {
            // Define variables
            // Add event modal
            const element = document.getElementById('kt_modal_add_event');
            form = element.querySelector('#kt_modal_add_event_form');
            eventName = form.querySelector('[name="calendar_event_name"]');
            eventDescription = form.querySelector('[name="calendar_event_description"]');
            eventLocation = form.querySelector('[name="calendar_event_location"]');
            startDatepicker = form.querySelector('#kt_calendar_datepicker_start_date');
            endDatepicker = form.querySelector('#kt_calendar_datepicker_end_date');
            startTimepicker = form.querySelector('#kt_calendar_datepicker_start_time');
            endTimepicker = form.querySelector('#kt_calendar_datepicker_end_time');
            addButton = document.querySelector('[data-kt-calendar="add"]');
            submitButton = form.querySelector('#kt_modal_add_event_submit');
            cancelButton = form.querySelector('#kt_modal_add_event_cancel');
            closeButton = element.querySelector('#kt_modal_add_event_close');
            modalTitle = form.querySelector('[data-kt-calendar="title"]');
            modal = new bootstrap.Modal(element);

            // View event modal
            const viewElement = document.getElementById('kt_modal_view_event');
            viewModal = new bootstrap.Modal(viewElement);
            viewEventName = viewElement.querySelector('[data-kt-calendar="event_name"]');
            viewAllDay = viewElement.querySelector('[data-kt-calendar="all_day"]');
            viewEventDescription = viewElement.querySelector('[data-kt-calendar="event_description"]');
            viewEventLocation = viewElement.querySelector('[data-kt-calendar="event_location"]');
            viewStartDate = viewElement.querySelector('[data-kt-calendar="event_start_date"]');
            viewEndDate = viewElement.querySelector('[data-kt-calendar="event_end_date"]');
            viewEditButton = viewElement.querySelector('#kt_modal_view_event_edit');

            getProjectDate();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppCalendar.init();
});
