@extends('layouts.app')
@section('style')
    <style>
        .my-field-error .fv-plugins-message-container,
        .my-field-error .fv-plugins-icon {
            font-size: 0.925rem;
            color: #f1416c;
            font-weight: 400;
        }
        div.contOne:not(:first-child){
            border-top:1px dashed #ccc;
            padding-top:16px;
        }
        button#delOutcome{
            display:none;
        }
        span.gfile {
            display:inline-block;
            margin-inline:8px 8px;
            color:#666;
        }
    </style>
@stop

@section('breadcrumbs')
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
        data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ __('project.all') }}
            <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{ __('title_nav.dashboard') }}</small>
        </h1>
    </div>
@stop

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-wrap flex-stack mb-6">
            <h3 class="fw-bold my-2">قائمة المشاريع</h3>
            <div class="d-flex flex-wrap my-2">
                @include('partials.backoffice.filter')
                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">{{ __('project.create') }}</a>
            </div>
        </div>
        <div class="row g-6 g-xl-9" id="projectList">
            @include('partials.backoffice.project.list')
        </div>
    </div>

    @include('backoffice.project.create')
    @if (Auth::user()->hasRole('project'))
        @include('backoffice.project.edit')
    @endif
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/utilities/modals/create-project.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/custom/backoffice/project.js') }}"></script>
@if (Auth::user()->hasRole('project'))
    @include('scripts.project-actions')
    <script src="{{ asset('assets/js/custom/utilities/modals/edit-project/master.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/edit-project/type.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/edit-project/main_data.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/edit-project/attachments.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/edit-project/opening.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/edit-project/closing.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/edit-project/complete.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/edit-project.js') }}"></script>
@endif

<script>
     $("button#addOutcome").on("click",function(){
       $("div.contOne:eq(0)").clone(true).appendTo("div#contAll");
       $("button#delOutcome").css({"display":"inline"});
     });
     $("button#delOutcome").on("click",function(){
       $("div.contOne:last-child:not(:first-child)").remove();
       if($("div.contOne:last-child").is(":first-child")) {
        $("button#delOutcome").hide();
       }
     });
     $("input#gooMaps").on("change",function(){
        $.ajax({
                url: "{{route('P.GoMap')}}",
                type: "POST",
                data: new FormData(document.querySelector("form.formCreate")),
                beforeSend: function() {
                    console.log("Please Wait ...");
                },
                processData: false,
                contentType: false,
                cache: false,
                success: function(data, status) {
                    $("div#goMaps").html(data);
                },
                error: function(xhr, desc, err) {}
            });
     });
    </script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/master.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/type.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/main_data.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/attachments.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/outcome.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/opening.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/closing.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/complete.js') }}"></script>
<script src="{{ asset('assets/js/custom/backoffice/delete-project.js') }}"></script>
<script src="{{ asset('assets/js/custom/backoffice/admin.js')}}"></script>

<script>
$("#project_date_range").daterangepicker({ format: 'yyyy-mm-dd' });
$("#edit_project_date_range").daterangepicker();

  $(window).on("load",function() {
    
    var a = $("form.formCreate div#openingStep").clone(true);
    var b = $("form.formCreate div#closingStep").clone(true);
    $("button#next-step").on("click",function(){
    if($("input.projectType:checked").val() == 13 || $("input.projectType:checked").val() == 14) {
        $("form.formCreate div#openingStep,form.formCreate div#closingStep").remove();
        $("div.openingStep,div.closingStep").hide();
        // $("button#type-back").css({"opacity":0}).attr({"disabled":true});
        $("button.OP span.indicator-label").html('<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"/><path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"/></svg></span> الاستكمال');
        $("button#close").removeClass("CLOSE");
        $("button#complete").removeClass("COMPLETE");
        $("button#closeBack").removeClass("CLOSEB");
        $("button#completeBack").removeClass("COMPLETEB");
    } else {
         if($("form.formCreate div#openingStep").length == 0){
             a.insertAfter("form.formCreate div#thirdStep");
             $("button#close").addClass("CLOSE");
             $("button#closeBack").addClass("CLOSEB");
             KTUtil.onDOMContentLoaded(function () {
                $("input[name='opening_date']").flatpickr({
                    minDate: "today",
                    dateFormat: "Y-m-d",
                    locale: 'ar',
                    time_24hr: false
                });});
         }
         if($("form.formCreate div#closingStep").length == 0){
             b.insertBefore("form.formCreate div#sixthStep");
             $("button#complete").addClass("COMPLETE");
             $("button#completeBack").addClass("COMPLETEB");
             KTUtil.onDOMContentLoaded(function () {
                $("input[name='closing_date']").flatpickr({
                    minDate: "today",
                    dateFormat: "Y-m-d",
                    locale: 'ar',
                    time_24hr: false
                });});
         }
        //$("button#type-back").css({"opacity":1}).attr({"disabled":false});
        $("div.openingStep,div.closingStep").show();
        $("button.OP span.indicator-label").html('<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"/><path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"/></svg></span> الافتتاح');
    }
   });
   $(document).on("click","button.CLOSE",function(){
        $(this).find("span.indicator-label").hide();
        $(this).find("span.indicator-progress").show();
        setTimeout(()=>{
            $("div#openingStep,div.openingStep").removeClass("current").addClass("completed");
            $("div#closingStep,div.closingStep").removeClass("pending").addClass("current");
            $(this).find("span.indicator-progress").hide();
            $(this).find("span.indicator-label").show();
        },2000);
   });

   $(document).on("click","button.CLOSEB",function(){
        $("div#openingStep,div.openingStep").removeClass("current").addClass("pending");
        $("div#thirdStep,div.thirdStep").removeClass("completed").addClass("current");
   });

   $(document).on("click","button.COMPLETE",function(){
    $(this).find("span.indicator-label").hide();
    $(this).find("span.indicator-progress").show();
    setTimeout(()=>{
        $("div#sixthStep,div.finalStep").removeClass("pending").addClass("current");
         $("div#closingStep,div.closingStep").removeClass("current").addClass("completed");
         $(this).find("span.indicator-progress").hide();
         $(this).find("span.indicator-label").show();
    },2000);
   
   });

   $(document).on("click","button.COMPLETEB",function() {
        $("div#openingStep,div.openingStep").removeClass("completed").addClass("current");
         $("div#closingStep,div.closingStep").removeClass("current").addClass("pending");
    });
});

    $("#chkall").click(function() {
        if($("#chkall").is(':checked')) {
            $("#region_ids > option").prop("selected", "selected");
            $("#region_ids").trigger("change");
        } else {
            $('#region_ids').val(null).trigger('change');            
            $("#region_ids > option").removeAttr("selected");
            $("#region_ids").trigger("change");
        }
    });
 </script>

<script>
    $(document).ready(function() {
        initialize();
    });
</script>

<script>
function initialize()
{
	// Set static latitude, longitude value
	var latlng = new google.maps.LatLng(24.810742547850356, 46.64769766431916);
	// Set map options
	var myOptions = {
		zoom: 12,
		center: latlng,
		panControl: true,
		zoomControl: true,
		scaleControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	// Create map object with options
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	// Create and set the marker
	marker = new google.maps.Marker({
		map: map,
		draggable:true,
		position: latlng
	});

	// Register Custom "dragend" Event
	google.maps.event.addListener(marker, 'dragend', function() {

		// Get the Current position, where the pointer was dropped
		var point = marker.getPosition();
		// Center the map at given point
		map.panTo(point);
		// Update the textbox
		document.getElementById('coordinates').value=point.lat()+", "+point.lng();
	});
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAz4-NaqNiTPgHXoTqSPsJwIRNQ9q53A_4&callback=initMap" type="text/javascript"></script>
@stop
