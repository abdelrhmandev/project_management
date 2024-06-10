@extends('layouts.app')

@section('style')
    <style>
        div.EQ {
            position: relative;
        }

        div.EQ a.Div {
            position: absolute;
            z-index: 10;
            top: 0;
            left: 0;
            font-size: 12px;
            padding: 4px 8px !important;
        }

        div.divWrap {
            display: flex;
        }

        div.divWrap>div {
            flex: 0 0 40%;
            margin: 10px 0 10px 20px;
            padding: 10px !important;
            box-sizing: border-box;
        }

        div.divWrap>div input,
        div.divWrap>div select {
            padding: 8px !important;
            box-sizing: border-box;
        }

        div.divWrap span,span.notes,span.files {
            color: #FF0000;
        }

        #divForm span.success {
            color: lightgreen;
        }
        div#tWrap {
        box-sizing: border-box;
        margin:20px 0 !important;
        padding: 0 !important;
        display:flex;  
        flex-wrap:wrap;
        justify-content:center;
    }
    div#tWrap .tCard {
        flex:0 0 40%;
        margin-bottom:14px;
        margin-left:20px;
        box-sizing: border-box;

    }
    article.oMsg {
        box-sizing: border-box;
        margin-top:14px;
    }
    article.oMsg::after {
       content:"";
       display:block;
       clear:both;
    }
    article.oMsg div.first {
        float:right;
        width:65px;
        margin-left:14px;
        box-sizing: border-box;
    }
    article.oMsg div.second {
        float:right;
        padding-top:15px;
        box-sizing: border-box;
    }
    article.oMsg div.second h4 {
        font-size:14px;
    }
    article.oMsg div.second span {
        color:gray;
        display:inline-block;
        margin-right:20px;
    }
    article.oMsg div.second p {
        color:gray;
        font-size:14px;
    }
    article.oMsg div.first img {
        display:block;
        width:100%;
        height:auto;
        border-radius:18px;
    }
    div.tCard div.card-body p img {
       display:inline-block;
       margin:5px 0 0 5px;
       vertical-align:bottom;
    }
    div.tCard div.card-body p {
       font-weight:normal;
       color:gray;
       font-size:12px;
       border-bottom:1px solid #333;
       box-sizing: border-box;
       padding-bottom:10px;
    }
    div.tCard div.card-body p::after {
        content:"";
       display:block;
       clear:both; 
    }
    div.tCard div.card-body p span {
       display:inline-block;
       color:#ccc;
       font-weight:normal;
       float:left;
       margin-top:13px;
       font-size:11px;
    }
    div.cardFooter ul{
     color:gray;
     padding:0 13px 0 0;
    }
    div.cardFooter ul li::after{
    content:"";
    display:table;
    clear:both;
    }
    div.cardFooter ul li a{
      float:left;
      font-size:10px;
      margin-top:-6px;
    }
    </style>
@append

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            @include('partials.backoffice.sidebar-project')
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <div class="tab-content" id="myTabContent">
                    <!--begin::Content-->
                    <div class="tab-pane fade show active">

                        @include('partials.backoffice.research-details')
                        <form class="form" action="{{ url('equipment/hand-offer-task') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                            @csrf
                            <div class="row g-5 g-xl-8">
                                <!--begin::general equipment-->
                                @if ($project_equipments->where('equipment_type', 1)->count() > 0)
                                    <div class="col-lg-12 col-xl-12">
                                        <!--begin::Contacts-->
                                        <div class="card" id="kt_contacts_list">
                                            <!--begin::Card header-->
                                            <div class="card-header pt-7" id="kt_contacts_list_header">
                                                <a href="#" class="fs-2 fw-bold me-1 text-gray-900">التجهيزات العامة</a>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body" id="researcherlist">
                                                <!--begin::List-->
                                                <div class="scroll-y me-n5 pe-5 h-600px h-xl-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">
                                                    @foreach ($project_equipments->where('equipment_type', 1) as $project_equipment)
                                                        <div class="EQ mb-2">
                                                            <a class="btn btn-primary Div" data-remain="{{$remaining_equipment->where('equipment_id', $project_equipment->equipment_id)->first()->remain}}" data-qty="{{$project_equipment->qty}}" data-type="1" data-item="{{ $project_equipment->equipment_id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_div">تقسيم الكمية</a>
                                                            <label id="mylist" class="d-flex flex-stack bg-active-lighten btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center rounded" for="kt_select_researcher . {{ $project_equipment->equipment_id }}">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-4">
                                                                        <input type="checkbox" class="form-check-input" name="equipment_id[]" value="{{ $project_equipment->equipment_id }}" id="kt_select_researcher . {{ $project_equipment->equipment_id }}" {{ $project_equipment->send_equipment_receipt == 1 ? 'checked' : '' }} {{ $project_transaction_history->is_done == 1 ? 'disabled' : '' }} />
                                                                        <span class="fs-6 fw-bold text-gray-900">{{ $project_equipment->title }}</span>
                                                                        <div class="fw-semibold fs-7 text-muted text-start">{{ $project_equipment->price }} SAR</div>
                                                                    </div>
                                                                </div>
                                                                <div class="fw-semibold text-muted align-items-end mt-5">
                                                                    @if ($project_equipment->send_equipment_receipt == 1)
                                                                        <span class="w-100px badge badge-light-success">الكمية المطلوبة {{ $project_equipment->qty }}</span>
                                                                    @else
                                                                        <span class="w-100px badge badge-light-warning">الكمية المطلوبة {{ $project_equipment->qty }}</span>
                                                                    @endif
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="separator separator-dashed d-none mt-4"></div>
                                                    @endforeach
                                                </div>
                                                <!--end::List-->
                                                
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                @endif
                                <!--end::general equipment-->

                                <div class="col-lg-12 col-xl-12">
                                    <a href="#" class="fs-2 fw-bold me-1 text-gray-900">المشرفين</a>
                                    <div class="col-xl-12 gap-7" id="tWrap">
                                        @foreach($supervisors as $v)
                                        <div class="card tCard">
                                            <div class="card-header cursor-pointer pt-5">
                                                <article class="oMsg">
                                                    <div class="first"><img src='{{asset("storage/{$v->avatar}")}}' alt=""></div>
                                                        <div class="second">
                                                        <h4 class="title">
                                                            {{$v->name}}
                                                        </h4>
                                                        <p>{{$v->email}}</p>
                                                    </div>
                                                </article>
                                            </div>
                                            <div class="card-body py-3">
                                            <p>
                                                <img src="{{asset('assets/media/team/vuesax-bold-location.png')}}" alt="area">
                                                    المنطقة
                                                <span>{{\App\Models\Region::find($v->region_id)->title}}</span>
                                                </p>
                                                <p>
                                                <img src="{{asset('assets/media/team/vuesax-bold-call.png')}}" alt="cellphone">
                                                رقم التليفون
                                                <span>{{$v->mobile}}</span>
                                                </p>
                                                <p>
                                                <img src="{{asset('assets/media/team/vuesax-linear-profile.png')}}" alt="cellphone">
                                                عدد الباحثين
                                                <span>
                                                {{\App\Models\ProjectObserverTeam::where(['project_id'=> $row->id,'type_id' => '5',
                                                    'superior_team_id' => $v->ID ])->count()}}
                                                </span>
                                                </p>
                                            
                                            <div class="cardFooter">
                                                <h6>التجهيزات المرسلة</h6>
                                                <ul>
                                                @php 
                                                $q= \App\Models\ProjectEquipmentsDiv::select('title','equipments.id AS EQID')
                                                ->join('equipments','equipments.id','=','project_equipments_division.equipment_id')
                                                ->groupBy('equipment_id')
                                                ->where('project_id',$row->id)->where('observer_id',$v->ID)->get();
                                                    @endphp
                                                    @foreach($q as $vv)
                                                    <li>{{$vv->title}} <a class="btn DivEdit" data-project="{{$row->id}}" data-observer="{{$v->ID}}" data-qty="{{\DB::table('project_equipments')->selectRaw('SUM(qty) AS Q')->where('project_id',$row->id)->where('equipment_id',$vv->EQID)->first()->Q}}" data-type="1" data-item="{{$vv->EQID}}" data-status="edit" data-bs-toggle="modal" data-bs-target="#kt_modal_div"><i class="fas fa-edit"></i>  تعديل</a></li>
                                                    @endforeach  
                                                </ul>
                                            </div>

                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>

                                <!--begin::training equipment-->
                                @if ($project_equipments->where('equipment_type', 2)->count() > 0)
                                    <div class="col-lg-12 col-xl-12">
                                        <!--begin::Contacts-->
                                        <div class="card" id="kt_contacts_list">
                                            <!--begin::Card header-->
                                            <div class="card-header pt-7" id="kt_contacts_list_header">
                                                <a href="#" class="fs-2 fw-bold me-1 text-gray-900">تجهيزات قسم التدريب</a>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body" id="researcherlist">
                                                <!--begin::List-->
                                                <div class="scroll-y me-n5 pe-5 h-600px h-xl-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">
                                                    @foreach ($project_equipments->where('equipment_type', 2) as $project_equipment)
                                                        <div class="EQ mb-2">
                                                            <label id="mylist" class="d-flex flex-stack bg-active-lighten btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center rounded" for="kt_select_researcher . {{ $project_equipment->equipment_id }}">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-4">
                                                                        <input type="checkbox" class="form-check-input" name="equipment_id[]" value="{{ $project_equipment->equipment_id }}" id="kt_select_researcher . {{ $project_equipment->equipment_id }}" {{ $project_equipment->send_equipment_receipt == 1 ? 'checked' : '' }} {{ $project_transaction_history->is_done == 1 ? 'disabled' : '' }} />
                                                                        <span class="fs-6 fw-bold text-gray-900">{{ $project_equipment->title }}</span>
                                                                        <div class="fw-semibold fs-7 text-muted text-start">{{ $project_equipment->price }} SAR</div>
                                                                    </div>
                                                                </div>
                                                                <div class="fw-semibold text-muted align-items-end mt-5">
                                                                    @if ($project_equipment->send_equipment_receipt == 1)
                                                                        <span class="w-100px badge badge-light-success">الكمية المطلوبة {{ $project_equipment->qty }}</span>
                                                                    @else
                                                                        <span class="w-100px badge badge-light-warning">الكمية المطلوبة {{ $project_equipment->qty }}</span>
                                                                    @endif
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="separator separator-dashed d-none mt-4"></div>
                                                    @endforeach
                                                </div>
                                                <!--end::List-->
                                                @include('backoffice.equipment.project_equipments_files', ['equipment_type' => 2])
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                @endif
                                <!--end::training equipment-->

                                <!--begin::opening project-->
                                @if ($project_equipments->where('equipment_type', 3)->count() > 0)
                                    <div class="col-lg-12 col-xl-12">
                                        <!--begin::Contacts-->
                                        <div class="card" id="kt_contacts_list">
                                            <!--begin::Card header-->
                                            <div class="card-header pt-7" id="kt_contacts_list_header">
                                                <a href="#" class="fs-2 fw-bold me-1 text-gray-900">تجهيزات إفتتاح مشروع</a>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body" id="researcherlist">
                                                <!--begin::List-->
                                                <div class="scroll-y me-n5 pe-5 h-600px h-xl-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">
                                                    @foreach ($project_equipments->where('equipment_type', 3) as $project_equipment)
                                                        <div class="EQ mb-2">
                                                            <label id="mylist" class="d-flex flex-stack bg-active-lighten btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center rounded" for="kt_select_researcher . {{ $project_equipment->equipment_id }}">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-4">
                                                                        <input type="checkbox" class="form-check-input" name="equipment_id[]" value="{{ $project_equipment->equipment_id }}" id="kt_select_researcher . {{ $project_equipment->equipment_id }}" {{ $project_equipment->send_equipment_receipt == 1 ? 'checked' : '' }} {{ $project_transaction_history->is_done == 1 ? 'disabled' : '' }} />
                                                                        <span class="fs-6 fw-bold text-gray-900">{{ $project_equipment->title }}</span>
                                                                        <div class="fw-semibold fs-7 text-muted text-start">{{ $project_equipment->price }} SAR</div>
                                                                    </div>
                                                                </div>
                                                                <div class="fw-semibold text-muted align-items-end mt-5">
                                                                    @if ($project_equipment->send_equipment_receipt == 1)
                                                                        <span class="w-100px badge badge-light-success">الكمية المطلوبة {{ $project_equipment->qty }}</span>
                                                                    @else
                                                                        <span class="w-100px badge badge-light-warning">الكمية المطلوبة {{ $project_equipment->qty }}</span>
                                                                    @endif
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="separator separator-dashed d-none mt-4"></div>
                                                    @endforeach
                                                </div>
                                                <!--end::List-->
                                                @include('backoffice.equipment.project_equipments_files', ['equipment_type' => 3])
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                @endif
                                <!--end::opening project-->

                                <!--begin::audit project-->
                                @if ($project_equipments->where('equipment_type', 4)->count() > 0)
                                    <div class="col-lg-12 col-xl-12">
                                        <!--begin::Contacts-->
                                        <div class="card" id="kt_contacts_list">
                                            <!--begin::Card header-->
                                            <div class="card-header pt-7" id="kt_contacts_list_header">
                                                <a href="#" class="fs-2 fw-bold me-1 text-gray-900">تجهيزات التدقيق</a>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body" id="researcherlist">
                                                <!--begin::List-->
                                                <div class="scroll-y me-n5 pe-5 h-600px h-xl-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">
                                                    @foreach ($project_equipments->where('equipment_type', 4) as $project_equipment)
                                                        <div class="EQ mb-2">
                                                            <label id="mylist" class="d-flex flex-stack bg-active-lighten btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center rounded" for="kt_select_researcher . {{ $project_equipment->equipment_id }}">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-4">
                                                                        <input type="checkbox" class="form-check-input" name="equipment_id[]" value="{{ $project_equipment->equipment_id }}" id="kt_select_researcher . {{ $project_equipment->equipment_id }}" {{ $project_equipment->send_equipment_receipt == 1 ? 'checked' : '' }} {{ $project_transaction_history->is_done == 1 ? 'disabled' : '' }} />
                                                                        <span class="fs-6 fw-bold text-gray-900">{{ $project_equipment->title }}</span>
                                                                        <div class="fw-semibold fs-7 text-muted text-start">{{ $project_equipment->price }} SAR</div>
                                                                    </div>
                                                                </div>
                                                                <div class="fw-semibold text-muted align-items-end mt-5">
                                                                    @if ($project_equipment->send_equipment_receipt == 1)
                                                                        <span class="w-100px badge badge-light-success">الكمية المطلوبة {{ $project_equipment->qty }}</span>
                                                                    @else
                                                                        <span class="w-100px badge badge-light-warning">الكمية المطلوبة {{ $project_equipment->qty }}</span>
                                                                    @endif
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="separator separator-dashed d-none mt-4"></div>
                                                    @endforeach
                                                </div>
                                                <!--end::List-->
                                                @include('backoffice.equipment.project_equipments_files', ['equipment_type' => 4])
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                @endif
                                <!--end::audit project-->
                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                @if ($project_transaction_history->is_done == 0)
                                    <div class="mt-8 text-center">
                                        <a href="#" class="btn btn-primary me-3" id="kt_save_general_equipment" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-trigger="hover">حفظ التغييرات فقط</a>
                                        <button type="submit" id="kt_edit_project_submit" class="btn btn-danger me-3">إنهاء وتسليم المهمة</button>
                                        <button type="reset" id="kt_cancel_equipment" class="btn btn-secondary me-3">إلغاء</button>
                                    </div>
                                @else
                                <div class="alert alert-dismissible bg-light-success border border-success border-dashed d-flex flex-column flex-sm-row p-5 mb-10">
                                    <span class="svg-icon svg-icon-2tx svg-icon-success me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor" />
                                            <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    
                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                        <h5 class="mb-1">تنبيه</h5>
                                        <span>لقد تم بالفعل إنهاء وتسليم المهمة بنجاح.</span>
                                    </div>
                                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                        <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                                    </button>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
            @include('backoffice.equipment._EqDivision', ['project' => $row->id])
        </div>
        @include('partials.obstacle._obstacle')
    </div>
@stop

@section('scripts')
<script> var LINK = "{{route('e.DivGetFile')}}";  </script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-account.js') }}"></script>
    <script src="{{ asset('assets/js/custom/account/referrals/referral-program.js') }}"></script>
    <script src="{{ asset('assets/js/custom/backoffice/equipment.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
    <script>
        "use strict";
        KTUtil.onDOMContentLoaded(function() {
            var eqDiv = document.getElementById("kt_div_eq_files");
            var typeOne = document.getElementById("kt_project_equipments_files_1");
            var typeTwo = document.getElementById("kt_project_equipments_files_2");
            var typeThree = document.getElementById("kt_project_equipments_files_3");
            var typeFour = document.getElementById("kt_project_equipments_files_4");

            if (eqDiv != null) {
                new Dropzone("#kt_div_eq_files", {
                    url: "{{ route('e.DivFile') }}",
                    method: "post",
                    paramName: "file",
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    acceptedFiles: "application/pdf,image/*",
                    autoProcessQueue: false, 
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function() {
                        var myDropzone = this;
                            $("button#divSend").click(function (e) {      
                            e.preventDefault();
                            if (myDropzone.getQueuedFiles().length > 0) {     
                            myDropzone.processQueue();
                            }else {
                                $.post("{{ route('e.DivFile') }}",$("form#divForm").serialize(),function(data){
                                    $("form#divForm span").html("");
                                    if(data.code == 400) {
                                        $("form#divForm span.observer").html(data.err.observer);
                                        $("form#divForm span.amount").html(data.err.amount);
                                        $("form#divForm span.notes").html(data.err.notes);
                                        $("form#divForm span.files").html(data.err.file);
                                    }else{
                                       // $("form#divForm span.success").html(data.MSG);
                                        setTimeout(()=>{
                                        window.location.reload();
                                        },1500);
                                    }
                                    });
                            }
                            });
                        this.on("sending", function(file, xhr, formData) {
                            formData.append("eqType", 1);
                            formData.append("project", $('#project_id').val());
                            formData.append("status",  $("form#divForm input[name=status]").val());
                            formData.append("amount",  $("form#divForm input[name=amount]").val());
                            formData.append("eqID", $("form#divForm input[name=eqID]").val());
                            formData.append("observer", $("form#divForm select[name=observer]").val());
                            formData.append("notes", $("form#divForm textarea[name=notes]").val());
                        });
                    },
                    accept: function(file, done) {
                        if (file.name == "wow.jpg") {
                            done("Naha, you don't.");
                        } else {
                            done();
                        }
                    },
                    success: function(file) {      
                        window.location.reload();
                        },
                });
            }

            if (typeOne != null) {
                new Dropzone("#kt_project_equipments_files_1", {
                    url: '{{ route('UploadProjectEquipmentFile') }}', // Set the url for your upload script location
                    method: "post",
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    acceptedFiles: "application/pdf,image/*",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function() {
                        this.on("sending", function(file, xhr, formData) {
                            formData.append("equipment_type", 1);
                            formData.append("project_id", $('#project_id').val());
                        });
                    },
                    accept: function(file, done) {
                        if (file.name == "wow.jpg") {
                            done("Naha, you don't.");
                        } else {
                            done();
                        }
                    }
                });
            }

            if (typeTwo != null) {
                new Dropzone("#kt_project_equipments_files_2", {
                    url: '{{ route('UploadProjectEquipmentFile') }}', // Set the url for your upload script location
                    method: "post",
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    acceptedFiles: "application/pdf,image/*",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function() {
                        this.on("sending", function(file, xhr, formData) {
                            formData.append("equipment_type", 2);
                            formData.append("project_id", $('#project_id').val());
                        });
                    },
                    accept: function(file, done) {
                        if (file.name == "wow.jpg") {
                            done("Naha, you don't.");
                        } else {
                            done();
                        }
                    }
                });
            }

            if (typeThree != null) {
                new Dropzone("#kt_project_equipments_files_3", {
                    url: '{{ route('UploadProjectEquipmentFile') }}', // Set the url for your upload script location
                    method: "post",
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    acceptedFiles: "application/pdf,image/*",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function() {
                        this.on("sending", function(file, xhr, formData) {
                            formData.append("equipment_type", 3);
                            formData.append("project_id", $('#project_id').val());
                        });
                    },
                    accept: function(file, done) {
                        if (file.name == "wow.jpg") {
                            done("Naha, you don't.");
                        } else {
                            done();
                        }
                    }
                });
            }

            if (typeFour != null) {
                new Dropzone("#kt_project_equipments_files_4", {
                    url: '{{ route('UploadProjectEquipmentFile') }}', // Set the url for your upload script location
                    method: "post",
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    acceptedFiles: "application/pdf,image/*",

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function() {
                        this.on("sending", function(file, xhr, formData) {
                            formData.append("equipment_type", 4);
                            formData.append("project_id", $('#project_id').val());
                        });
                    },
                    accept: function(file, done) {
                        if (file.name == "wow.jpg") {
                            done("Naha, you don't.");
                        } else {
                            done();
                        }
                    }
                });
            }
        });

        function deleteProjectEquipmentFile(file, projectId, eqType) {
            Swal.fire({
                text: "{{ __('site.confirmMultiDeleteMessage') }}" + "؟",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                confirmButtonText: "{{ __('site.confirmButtonText') }}",
                cancelButtonText: "{{ __('site.cancelButtonText') }}",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                },
            }).then(function(result) {
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('RemoveProjectEquipmentFile') }}',
                    data: {
                        '_method': 'delete',
                        'file': file,
                        'projectId': projectId,
                        'eqType': eqType,
                    },
                    success: function(response, textStatus, xhr) {
                        if (result.value) {
                            $("[data-file='" + file + "']").hide(500);
                            Swal.fire({
                                text: "{{ __('site.deletingselecteditem') }}",
                                icon: "info",
                                buttonsStyling: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                Swal.fire({
                                    text: response['msg'], // respose from controller
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function() {
                                    // delete row data from server and re-draw datatable
                                    //  dt.draw();
                                });
                                // location.reload();
                            });
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "{{ __('site.notdeletedMessage') }}",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    }
                });
            });
        }
    </script>
@stop
