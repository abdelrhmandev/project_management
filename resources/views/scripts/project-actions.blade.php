<script>
    // get Customer data ajax
    var customer_id;
    $('#customer_id').change(function(){
            customer_id = $('#customer_id').val();
            if(customer_id > 0){
            $.ajax({
                type: 'GET',
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('getCustomerInfo') }}",
                data: {
                    id: customer_id
                },
                success: function(data) {
                    if(data.id > 0){
                        $('#CustomerDataJaxResponse').removeClass('d-none');
                        document.getElementById("ResName").innerHTML=data.principal_name;                        
                        var url  = ("/admin/customers/edit/"+data.id);                        
                        document.getElementById("ResLink").innerHTML="<a href=\""+url+"\" class=\"btn btn-light-success\" style=\"margin-right: 30px;\">تعديل بيانات المسؤول</a>";

                    }else{
                        $('#CustomerDataJaxResponse').addClass('d-none');
                    }
                }
            });
            }else{
                $('#CustomerDataJaxResponse').addClass('d-none');
            }
           
        });

    document.addEventListener("DOMContentLoaded", function() {
        // Supporter Modal
        var project_id;
        $(".edit-project-url").click(function() {
            project_id = $(this).attr('data-id');
            $.ajax({
                type: 'GET',
                url: "{{ route('projects.editModal') }}",
                data: {
                    id: project_id
                },
                success: function(data) {
                    $("#id").val(data.row.id);

                    // Step 1
                    $("#edit_type_id").val(data.row.type_id);
                    document.getElementById("type_title").innerHTML = data.type.title;
                    document.getElementById("typesrc").src = data.project_type_icon;

                    // Step 2
                    $('#edit_title').val(data.row.title);
                    $('#project_title').html('"' + data.row.title + '"');
                    $('#edit_customer_id').val(data.row.customer_id);
                    $('#edit_customer_id').select2().trigger('change');
                    $('#edit_region_ids').val(data.region_ids);
                    $('#edit_region_ids').select2().trigger('change');

                    var start = data.row.start_date;
                    var end = data.row.end_date;
                    var label = '';

                    $('#edit_project_date_range').daterangepicker({
                            startDate: moment().subtract('days', 29),
                            endDate: moment(),
                            minDate: start,
                            maxDate: end,

                            showDropdowns: true,
                            showWeekNumbers: true,

                            opens: 'left',
                            buttonClasses: ['btn btn-default'],
                            applyClass: 'btn-small btn-primary',
                            cancelClass: 'btn-small',
                            format: 'yyyy-mm-dd',
                            separator: ' to ',
                            locale: {
                                applyLabel: 'Submit',
                                fromLabel: 'From',
                                toLabel: 'To',
                                customRangeLabel: 'Custom Range',
                                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                                monthNames: ['January', 'February', 'March', 'April',
                                    'May', 'June', 'July', 'August', 'September',
                                    'October', 'November', 'December'
                                ],
                                firstDay: 1
                            }
                        },

                    );

                    $('#edit_project_date_range').val(start + ' - ' + end);



                    $('#edit_mine_title').val(data.mine_title);
                    $('#edit_cases_count').val(data.row.cases_count);
                    $('#edit_building_count').val(data.row.building_count);
                    $('#edit_charity_count').val(data.charity_count);

                    if (data.training_type) {
                        $('#edit_training_count').val(data.training_type.training_count);
                        $('#edit_training_on').val(data.training_type.training_on);
                        $('#edit_training_type').val(data.training_type.training_type);
                        $('#edit_training_type').select2().trigger('change');
                        $('#edit_participant_type').val(data.training_type
                        .participant_type);
                        $('#edit_participant_type').select2().trigger('change');
                        $('#edit_training_date').val(data.training_type.training_date);
                        $('#edit_duration').val(data.training_type.duration);
                        if (data.training_type.is_hall_required == 1) {
                            $("#edit_is_hall_required").prop("checked", true);
                        }
                    }

                    // Step 3
                    $('.image-input-placeholder_edit').css('background-image',
                        'url(' + data.logo + ')');

                    if (data.research_survey) {
                        $('#edit_research_survey').html(
                            '<div class="card-body d-flex"> <a href="' + data
                            .research_survey +
                            '" class="text-gray-800 text-hover-primary d-flex flex-column"> <div class="symbol symbol-60px mb-5"> <img src="' +
                            pdf_icon +
                            '" class="theme-light-show" alt=""></div></a></div>'
                        );
                    }

                    if (data.rfp) {
                        $('#edit_rfp').html(
                            '<div class="card-body d-flex"> <a href="' + data.rfp +
                            '" class="text-gray-800 text-hover-primary d-flex flex-column"> <div class="symbol symbol-60px mb-5"> <img src="' +
                            data.pdf_icon +
                            '" class="theme-light-show" alt=""></div></a></div>'
                        );
                    }

                    if (data.additional_questions) {
                        $('#edit_additional_questions').html(
                            '<div class="card-body d-flex"> <a href="' + data
                            .additional_questions +
                            '" class="text-gray-800 text-hover-primary d-flex flex-column"> <div class="symbol symbol-60px mb-5"> <img src="' +
                            data.pdf_icon +
                            '" class="theme-light-show" alt=""></div></a></div>'
                        );
                    }

                    if (data.requirements_specifications) {
                        $('#edit_requirements_specifications').html(
                            '<div class="card-body d-flex"> <a href="' + data
                            .requirements_specifications +
                            '" class="text-gray-800 text-hover-primary d-flex flex-column"> <div class="symbol symbol-60px mb-5"> <img src="' +
                            data.pdf_icon +
                            '" class="theme-light-show" alt=""></div></a></div>'
                        );
                    }

                    if (data.google_map) {
                        $('#edit_google_map').html(
                            '<div class="card-body d-flex"> <a href="' + data
                            .google_map +
                            '" class="text-gray-800 text-hover-primary d-flex flex-column"> <div class="symbol symbol-60px mb-5">   <img src="' +
                            data.pdf_icon +
                            '" class="theme-light-show" alt=""></div></a></div>'
                        );
                    }

                    if (data.charity_list_file) {
                        $('#edit_charity_list').html(
                            '<div class="card-body d-flex"> <a href="' + data
                            .charity_list_file +
                            '" class="text-gray-800 text-hover-primary d-flex flex-column"> <div class="symbol symbol-60px mb-5"> <img src="' +
                            data.pdf_icon +
                            '" class="theme-light-show" alt=""></div></a></div>'
                        );
                    }

                    if (data.training_type) {
                        if (data.training_type.training_agenda) {
                            $('#edit_training_agenda').html(
                                '<div class="card-body d-flex"> <a href="' + data
                                .training_type.training_agenda +
                                '" class="text-gray-800 text-hover-primary d-flex flex-column"> <div class="symbol symbol-60px mb-5"> <img src="' +
                                data.pdf_icon +
                                '" class="theme-light-show" alt=""></div></a></div>'
                            );
                        }
                        if (data.training_type.trainee_list) {
                            $('#edit_trainee_list').html(
                                '<div class="card-body d-flex"> <a href="' + data
                                .training_type.trainee_list +
                                '" class="text-gray-800 text-hover-primary d-flex flex-column"> <div class="symbol symbol-60px mb-5"> <img src="' +
                                data.pdf_icon +
                                '" class="theme-light-show" alt=""></div></a></div>'
                            );
                        }
                    }
                    // Step 4
                    if (data.row.opening == 1) {
                        $("#opening_edit").prop("checked", true);
                        document.getElementById('opening_div_edit').classList.remove(
                            "d-none");
                    } else {
                        $("#opening_edit").prop("checked", false);
                        document.getElementById('opening_div_edit').classList.add("d-none");
                    }
                    if (data.row.opening_reserve_hall == 1) {
                        $("#opening_reserve_hall_edit").prop("checked", true);
                    }
                    if (data.row.opening_attendance_nature == 'regulars') {
                        $("#opening_attendance_nature_regulars_edit").prop("checked", true);
                        document.getElementById("edit_opening_regulars_label").className =
                            "btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6";
                    }
                    if (data.row.opening_attendance_nature == 'leaders') {
                        $("#opening_attendance_nature_leaders_edit").prop("checked", true);
                        document.getElementById("edit_opening_leaders_label").className =
                            "btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6";
                    }
                    $('#opening_date_edit').val(data.row.opening_date);



                    if (data.row.flexibility_project_dates == 1) {
                        $("#flexibility_project_dates").prop("checked", true);

                    } else {
                        $("#flexibility_project_dates").prop("checked", false);

                    }




                    // Step 5
                    if (data.row.closing == 1) {
                        $("#closing_edit").prop("checked", true);
                        document.getElementById('closing_div_edit').classList.remove(
                            "d-none");
                    } else {
                        $("#closing_edit").prop("checked", false);
                        document.getElementById('closing_div_edit').classList.add("d-none");
                    }
                    if (data.row.closing_reserve_hall == 1) {
                        $("#closing_reserve_hall_edit").prop("checked", true);
                    }

                    if (data.row.closing_attendance_nature == 'regulars') {
                        $("#closing_attendance_nature_regulars_edit").prop("checked", true);
                        document.getElementById("edit_closing_regulars_label").className =
                            "btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6";
                    }

                    if (data.row.closing_attendance_nature == 'leaders') {
                        $("#closing_attendance_nature_leaders_edit").prop("checked", true);
                        document.getElementById("edit_closing_leaders_label").className =
                            "btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6";
                    }
                    $('#closing_date_edit').val(data.row.closing_date);
                }
            });
            $("#kt_modal_edit_project").modal('show');
        });
    });
</script>
