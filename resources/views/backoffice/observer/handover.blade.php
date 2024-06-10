@extends('layouts.app')

@section('style')
  <style>
  td.current {
    cursor:pointer;
  }
  td.current:hover {
    color:gray;
  }
  table.RES {
    background-color:#333333;
    color:#fff;
  }
  table.RES th {
   color:#aaa;
  }
  table.RES tr td:first-child,table.RES tr th:first-child {
   padding-right:10px !important;
   box-sizing:border-box;
  }
  table.RES tr td:first-child {
   font-size:12px;
  }
  td.tdd div button {
    padding:4px 10px !important;
    box-sizing:border-box;
  }
  td.tdd div.tdOpt {
    position:relative;
  }
  div.tdnote {
    position:fixed;
    z-index:200;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    min-width:25.75em;
    background-color:#333;
    color:#fff;
    box-sizing:border-box;
    border:1px solid #444;
    box-shadow:2px 2px 16px #666;
    display:none;
  }
  div.tdnote form a {
   color:#fff !important;
   margin-right:10px;
  }
  div.tdnote form div {
    margin:8px 10px;
    box-sizing:border-box;
    font-size:0.875rem;
  }
  div.tdnote form div input{
    border:1px solid #999;
  }
  div.tdnote form textarea {
    margin:5px 10px;
    box-sizing:border-box;
    width:94% !important;
    font-size:0.875rem;
    border:1px solid #999;
    background-color:transparent;
  }
  div.btnWrap {
    display:flex;
    justify-content:center;
    align-items:center;
  }
  div.tdnote button.btn-primary{
    position:relative; 
    margin:6px 0;
  }
  div.tdnote span{
    position:absolute;
    z-index:4;
    top:1px;
    left:10px;
   font-size:1.99rem;
   transition:0.5s linear;
   cursor:pointer;
  }
  div.tdnote span:hover{
    transform:rotateY(360deg);
  }
  div.tdOpt span{
    display:inline-block;
    color:lightgreen;
  }
    </style>
@stop

@section('content')
<div id="kt_content_container" class="container-xxl">
    
<div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ asset('storage/' . $row->logo) }}" alt="{{ $row->title }}" />
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                        </div>
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1" style="display:inline-block;{{ mb_strlen($row->title) > 40 ? ' width:350px;' : '' }}">
                                    {{ $row->title }}
                                </a>
                                <a href="#">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                    <span class="svg-icon svg-icon-1 svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                            <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="currentColor" />
                                            <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a href="#" class="btn btn-sm btn-light-{{ $row->status->class }} fw-bold ms-2 fs-8 py-1 px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">{{ $row->status->trans }}</a>
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#" style="width:550px;" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                            <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    @foreach ($row->region as $region)
                                    {{ $region->title }},
                                    @endforeach
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::Actions-->
                        <div class="d-flex my-4">
                            <div class="d-flex {{ $row->status_id == 11 ? '' : ($row->status_id == 13 ? '' : 'invisible') }}">
                                <form class="form" id="FormId" data-route-url="{{ url('operation/end-field') }}" enctype="multipart/form-data" novalidate="novalidate" method="POST">
                                    @csrf
                                    <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                    <input type="hidden" id="redirectUrl" data-redirect-url="{{ url('operation/followup/' . $row->id) }}" />
                                    <input type="hidden" name="project_title" id="project_title" value="{{ $row->title }}" />
                                    <button type="button" class="btn btn-sm btn-primary me-2" id="kt_page_loading_overlay">إنهاء العمل الميداني</button>
                                </form>
                            </div>
                            <a href="#" class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_contact_information">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
                                <span class="svg-icon svg-icon-3 d-none">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
                                        <path d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--begin::Indicator label-->
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                </svg>
                                <span class="indicator-label">معلومات التواصل</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">الرجاء الإنتظار...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </a>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-2 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-6 fw-bold">{{ $row->customer->title }}</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">إسم الجهة</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-100px py-3 px-2 me-2 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-6 fw-bold">{{ $row->type->title }}</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">نوع المشروع</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-2 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-6 fw-bold">من {{ $row->start_date }} إلى {{ $row->end_date }}
                                        </div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">المدة الزمنية للمشروع</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center w-180px w-sm-300px flex-column mt-3">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-semibold fs-6 text-gray-400">إكتمال المشروع</span>
                                <span class="fw-bold fs-6">{{ $row->progress_bar }}%</span>
                            </div>
                            <div class="h-5px mx-3 w-100 bg-light mb-3">
                                <div class="bg-success rounded h-5px" role="progressbar" style="width: {{ $row->progress_bar }}%;" aria-valuenow="{{ $row->progress_bar }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
        </div>
    </div>

     <a href="#" class="fs-2 fw-bold me-1 text-gray-900">التجهيزات</a>
           <br><br>
    <div class="card">
        <div class="card-body pt-4">
            @if(session()->has('successMSG'))
            <div class="alert alert-success">{{session('successMSG')}}</div>
            @endif
         <form action="{{route('eq.return')}}" method="post">
                @csrf 
                @method('PUT')
            <input type="hidden" name="project" value="{{$row->id}}">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>&nbsp;</th>
                        <th class="min-w-5px">اسم التجهيز</th>
                        <th class="min-w-5px">العدد</th>
                        <th class="min-w-125px">الملاحظات</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">
                @foreach($eq as $v)
                @php 
                 @$RER = \DB::table('project_equipments AS PE')
                    ->where('project_id',$row->id)
                    ->where('equipment_type','1')
                    ->where('equipment_id',$v->EQID)->first()->return_equipment_receipt;
                    $checked = ($RER == 1) ? 'checked' : '';
                @endphp
                    <tr>
                    <td>
                    <input class="form-check-input" name="eqName[]" type="checkbox" value="{{$v->EQID}}" {{$checked}}>
                    </td>
                    <td class="current" data-item="{{$v->EQID}}" data-project="{{$row->id}}" data-bs-toggle="modal" data-bs-target="#kt_modal_div_eq">{{$v->title}}</td>
                    <td>{{$v->amount}}</td>
                    <td>{{$v->notes}}</td>
                   </tr>
                   @endforeach
                </tbody>
            </table>
    <br>
    @if($exist)
   <div class="dropzone" id="kt_div_obs_files">
    <div class="wrapperdz">
    @if(isset($shipFiles->SHPF) && !is_null($shipFiles->SHPF))
    @php $files = json_decode($shipFiles->SHPF); @endphp
    @foreach($files as $k=>$f)
    
    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" data-file='{{$k}}'>
        <div class="dz-image">
            @if(pathinfo(asset('storage' . $files->$k), PATHINFO_EXTENSION) == 'pdf')
            <a href="{{ asset('storage'.$files->$k) }}">
                <img class="py-2" data-dz-thumbnail="" alt="1" src="{{ asset('assets/media/svg/files/'.\File::extension(asset('storage' . $files->$k)).'.svg') }}" width="120px" height="120px">
            </a>
            @else
            <a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ asset('storage'.$files->$k) }}">
                <img data-dz-thumbnail="" alt="{{ asset('storage'.$files->$k) }}" src="{{ asset('storage'.$files->$k) }}" width="120px" height="120px">
            </a>
            @endif
        </div>
        <div class="dz-progress">
            <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
        </div>
        <div class="dz-error-message"><span data-dz-errormessage=""></span>
        </div>
        <div class="dz-success-mark">
            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>Check</title>
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF"></path>
                </g>
            </svg>
        </div>
        <div class="dz-error-mark">
            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>Error</title>
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                        <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"></path>
                    </g>
                </g>
            </svg>
        </div>
        <a class="dz-remove" href="javascript:void(0);" onclick="_delSHPF('{{$k}}',{{$row->id}});" data-dz-remove="">Remove file</a>
    </div>
    @endforeach
    @endif
    </div>
    <!--begin::Message-->
    <div class="dz-message needsclick">
        <!--begin::Icon-->
        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
        <!--end::Icon-->

        <!--begin::Info-->
        <div class="ms-4">
            <h3 class="fs-5 fw-bold text-gray-900 mb-1">يمكنك رفع ملفات الشحن للمراقب من هنا</h3>
            <span class="fs-7 fw-semibold text-gray-400">عدد الملفات المسموح به 10 ملفات</span>
        </div>
        <!--end::Info-->
    </div>
</div>
<br>
                <input class="btn btn-primary" type="submit" name="save" value="حفظ التغييرات">
            @endif
            </form>
        </div>
    </div>
    <br>
    <a href="#" class="fs-2 fw-bold me-1 text-gray-900">الباحثين</a>
    <br><br>
    <div class="card">
        <div class="card-body pt-4">
        @php $count = \App\Models\Project::count(); @endphp
        @foreach($supervisors as $v)  
        <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-5px">اسم المشرف</th>
                        <th class="min-w-5px">تاريخ الانضمام</th>
                        <th class="min-w-5px">المشاريع المكتملة</th>
                        <th class="min-w-5px">الاداء</th>
                        <th class="min-w-5px">&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">
                <tr>
                    <td><h5>{{$v->name}}</h5></td>
                    <td><span class="badge text-bg-info">{{$v->enrolled_date}}</span></td>
                    <td>
                       <label for="resa_{{$v->ID}}">{{$v->accomplished_projects}}</label> 
                        <progress id="resa_{{$v->ID}}" value="{{$v->accomplished_projects}}" max="{{$count}}"></progress>
                    </td>
                    <td>
                      <label for="resp_{{$v->ID}}">% {{$v->performance_percentage}}</label> 
                       <meter id="resp_{{$v->ID}}" value="{{$v->performance_percentage / 100}}"></meter>
                     </td>
                     <td class="tdd">
                        <div class="tdOptmodal">
                         <span data-team="t-{{$v->TUID}}"></span>
                         @if(is_null($v->is_good))
                           <button type="button" class="btn btn-sm btn-success" data-btn="s-{{$v->TUID}}" onclick="_goodOrNot({{$row->id}},{{$v->TUID}},'good');">سليم</button>
                           <button type="button" class="btn btn-sm btn-warning" data-btn="ns-{{$v->TUID}}" data-bs-toggle="modal" data-bs-target="#modalsuper-{{$v->ID}}">غير سليم</button>
                           <div class="modal fade" id="modalsuper-{{$v->ID}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-1000px">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h3><i class="bi bi-eye-fill" style="color:#fff;font-size:1.3rem;"></i> التفاصيل</h3>
                                        <br>
                                    </div>
                                    <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
                                    <form>
                                            <a href="#" class="fw-bold text-gray-900">التجهيزات</a><br><br>
                                            @foreach($eq as $e)
                                            <div>
                                            <input class="form-check-input" name="EQ" type="checkbox" value="{{$e->EQID}}">
                                                    {{$e->title}}
                                            </div>
                                                @endforeach
                                                <br>
                                                <textarea class="form-control" placeholder="أكتب ملاحظاتك"></textarea>
                                                
                                                <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                                                 <input type="button" class="btn" data-bs-dismiss="modal" value="إلغاء" style="float:left;background:#F60F37;color:#fff;margin:0 10px;">
                                                <input type="button" class="btn" onclick="_goodOrNot({{$row->id}},{{$v->TUID}},'notGood',$(this).parents().filter('form').find('textarea').val(),$(this).parents().filter('form').serialize());" style="float:left;background: #004A61; color:white" value="إرسال">
                                                </div>
                                            </form>
                                        
                                    </div>
                           @endif
                        </div>
                     </td>
                     </tr>
                </tbody>
            </table>

        <table class="RES table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-5px">اسم الباحث</th>
                        <th class="min-w-5px">تاريخ الانضمام</th>
                        <th class="min-w-5px">المشاريع المكتملة</th>
                        <th class="min-w-5px">الاداء</th>
                        <th class="min-w-5px">التقييم</th>
                        <th class="min-w-5px">&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">
                @php 
                    $researchers = \DB::table('project_observer_team AS POT')
                        ->join('attracting_team AS AT','AT.id','=','POT.team_user_id')
                        ->select('AT.id AS ID','name','enrolled_date','superior_team_id','accomplished_projects','performance_percentage','is_good')
                        ->where('POT.type_id',5)
                        ->where('POT.project_id',$row->id)
                        ->where('superior_team_id',$v->TUID)->get();
                    @endphp
                 @foreach($researchers as $vv)
                    <tr>
                    <td>{{$vv->name}}</td>
                    <td><span class="badge text-bg-info">{{$vv->enrolled_date}}</span></td>
                    <td>
                       <label for="resa_{{$vv->ID}}">{{$vv->accomplished_projects}}</label> 
                        <progress id="resa_{{$vv->ID}}" value="{{$vv->accomplished_projects}}" max="{{$count}}"></progress>
                    </td>
                    <td>
                      <label for="resp_{{$vv->ID}}">% {{$vv->performance_percentage}}</label> 
                       <meter id="resp_{{$vv->ID}}" value="{{$vv->performance_percentage / 100}}"></meter>
                     </td>
                    <td>
                      @php 
                        @$eval = \App\Models\ProjectEvaluation::where([
                            'type_id' => 5 ,
                             'team_user_id' => $vv->ID,
                             'project_id' => $row->id
                            ])->first()->evaluate;
                            $i=1;
                            $j=1;
                       @endphp
                        @while($i <= $eval)
                          <i class="bi bi-star-fill" style="color:darkorange;font-size:16px;"></i>
                          @php $i++;  @endphp 
                        @endwhile
                        @while($j <= (5 - $eval))
                          <i class="bi bi-star" style="color:darkorange;font-size:16px;"></i>
                          @php $j++;  @endphp 
                        @endwhile
                    </td>
                    <td class="tdd">
                        <div class="tdOptmodal">
                         <span data-team="t-{{$vv->ID}}"></span>
                         @if(is_null($vv->is_good))
                           <button type="button" class="btn btn-sm btn-success" data-btn="s-{{$vv->ID}}" onclick="_goodOrNot({{$row->id}},{{$vv->ID}},'good');">سليم</button>
                           <button type="button" class="btn btn-sm btn-warning" data-btn="ns-{{$vv->ID}}" data-bs-toggle="modal" data-bs-target="#modalres-{{$vv->ID}}">غير سليم</button>
                           <div class="modal fade" id="modalres-{{$vv->ID}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-1000px">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h3><i class="bi bi-eye-fill" style="color:#fff;font-size:1.3rem;"></i> التفاصيل</h3>
                                        <br>
                                    </div>
                                    <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
                                    <form>
                                            <a href="#" class="fw-bold text-gray-900">التجهيزات</a><br><br>
                                            @foreach($eq as $e)
                                            <div>
                                            <input class="form-check-input" name="EQ" type="checkbox" value="{{$e->EQID}}">
                                                    {{$e->title}}
                                            </div>
                                                @endforeach
                                                <br>
                                                <textarea class="form-control" placeholder="أكتب ملاحظاتك"></textarea>
                                                
                                                <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                                                 <input type="button" class="btn" data-bs-dismiss="modal" value="إلغاء" style="float:left;background:#F60F37;color:#fff;margin:0 10px;">
                                                <input type="button" class="btn" onclick="_goodOrNot({{$row->id}},{{$vv->ID}},'notGood',$(this).parents().filter('form').find('textarea').val(),$(this).parents().filter('form').serialize());" style="float:left;background: #004A61; color:white" value="إرسال">  
                                                </div>
                                            </form>
                                        
                                    </div>
                           @endif
                        </div>
                     </td>
                   </tr>
                   @endforeach
                </tbody>
            </table>
            @endforeach
          </div>
    </div>

    <br>
    <form action="{{route('obs.endTask',['project' => $row->id])}}" method="post">
        @csrf 
        @method('PATCH')
        <input class="btn btn-warning" type="submit" name="saveAll" value="إنهاء وتسليم المهمه">
    </form>
</div>

<!--modal-->
<div class="modal fade res" id="kt_modal_div_eq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold" id="eqName"></h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>

            <div class="modal-body scroll-y pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <tbody class="fw-semibold">
                    <tr>
                    <th>العدد</th>
                    <td id="amount"></td>
                   </tr>
                   <tr>
                    <th>الملاحظات</th>
                    <td id="notes"></td>
                   </tr>
                   <tr>
                    <th>الملفات</th>
                    <td id="files"></td>
                   </tr>
                </tbody>
            </table>       
            </div>
        </div>
    </div>
</div>
<!--begin::Modal - contact information-->
@include('partials.backoffice.contact-information-modal')
<!--end::Modals - contact information-->
@stop

@section('scripts')
<script>
    var LINK = "{{route('divEQ.info')}}";
    var url = "{{asset('/storage')}}";
    var ext = "{{asset('assets/media/svg/files/pdf.svg')}}";
$("td.current").on("click",function(){
    $.get(LINK,{"P":$(this).data("project"),"E":$(this).data("item")},function(data){
      $("h2#eqName").html(data.eq.title);
      $("td#amount").html(data.eq.amount);
      $("td#notes").html(data.eq.notes);
      const a = JSON.parse(data.eq.files);
      var html = "";
      for(let x in a) {
        if(a[x].includes('.pdf')){
          html += "<a href='"+url+a[x]+"'><img src='"+ext+"' width='70px'></a>";
        }else {
          html += "<a href='"+url+a[x]+"'><img src='"+url+a[x]+"' width='70px'></a>"; 
        }
      }
      $("td#files").html(html);
 });
});
@if($exist)
new Dropzone("#kt_div_obs_files", {
                    url: "{{ route('obs.shipment') }}",
                    method: "post",
                    paramName: "file",
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    acceptedFiles: "application/pdf,image/*",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function() {
                        this.on("sending", function(file, xhr, formData) {
                            formData.append("_method", "PUT");
                            formData.append("eqType", 1);
                            formData.append("project",{{$row->id}});
                            formData.append("observer",{{\Auth::user()->id}});
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
    
    var _delSHPF = (f,p) => {
       $.post("{{route('obs.delShp')}}",{'F':f,'P':p,'_token':'{{csrf_token()}}','_method':'PATCH'},function(data){
          $("div[data-file='"+f+"']").fadeOut();
       });
    }
@endif 
$("div.tdOpt button.btn-warning").on("click",function(){
    $("<div id='overlay'></div>").css({'position':'fixed','z-index':'199','width':'100%','height':'100%','background-color':'rgba(0,0,0,0.6)'}).appendTo('body');
      $(this).parent().find("div.tdnote").slideToggle();
});
$("div.tdnote span").on("click",function(){
    $(this).parent().slideUp();
    $('div#overlay').remove();
});
$(document).on("click","div#overlay",function(){
    $("div.tdnote").slideUp();
    $(this).remove();
});
var _goodOrNot = (p,t,g,r="",e="") => {
  $.post("{{route('obs.GON')}}",{'P':p,'T':t,'G':g,'R':r,'E':e,'_token':'{!!csrf_token()!!}','_method':'PATCH'},function(data){
    $("div.tdOpt span[data-team='t-"+t+"']").html(data.success); 
    $("div.tdnote").slideUp();
        $("button[data-btn='s-"+t+"']").fadeOut();
        $("button[data-btn='ns-"+t+"']").fadeOut();
    setTimeout(()=>{
        $("div.tdOpt span[data-team='t-"+t+"']").html(""); 
    },2000);
  });
}
</script>
@stop