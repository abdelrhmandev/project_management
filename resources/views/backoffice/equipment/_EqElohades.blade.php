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
    margin:10px 15px 10px 0;
    width:97%;
  }
  table.RES th {
   color:#aaa;
  }
  table.RES tr td:first-child,table.RES tr th:first-child {
   padding-right:20px !important;
   box-sizing:border-box;
  }
  table.RES tr td:first-child {
   font-size:12px;
  }
table.super {
    background-color:#444;
    color:#fff !important;
}
table.super th {
   color:#aaa;
  }
  table.super td h6,table.super td span,table.RES td span {
    color:#fff !important;
  }
table.super tr td:first-child,table.super tr th:first-child {
   padding-right:10px !important;
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
    padding:16px;
    box-shadow:2px 2px 16px #666;
    display:none;
  }
  div.tdnote a {
   color:#fff !important;
   margin-right:10px;
   padding:5px 18px !important;
   margin-bottom:10px;
  }
  div.tdnote li,div.tdnote p {
    font-size:0.88rem;
    line-height:1.8;
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
  div.tdOpt button.btn-dark{
    padding:5px 8px !important;
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

    <br>
    <a href="#" class="fs-2 fw-bold me-1 text-gray-900">فريق العمل</a>
    <br><br>
    <div class="card">
        <div class="card-body pt-4">
        @php $count = \App\Models\Project::count(); @endphp
        @foreach($allTeam as $k => $v)  
        <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-5px">اسم المراقب</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">
                <tr>
                    <td><h3>{{$v['name']}}</h3></td>
                     </tr>
                </tbody>
            </table>
            @if(!empty($v['supervisors']))
            @foreach($v['supervisors'] as $vv) 
              <table class="super table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-5px">اسم المشرف</th>
                        <th class="min-w-5px">تاريخ الانضمام</th>
                        <th class="min-w-5px">المشاريع المكتملة</th>
                        <th class="min-w-5px">الاداء</th>
                        <th class="min-w-5px">حالة التجهيزات</th>
                        <th class="min-w-5px">التجهيزات والملاحظات</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">
                <tr>
                    <td><h6>{{$vv['name']}}</h6></td>
                    <td><span class="badge text-bg-info">{{$vv['enrolled_date']}}</span></td>
                    <td>
                       <label for="resa_{{$vv['id']}}">{{$vv['accomplished_projects']}}</label> 
                        <progress id="resa_{{$vv['id']}}" value="{{$vv['accomplished_projects']}}" max="{{$count}}"></progress>
                    </td>
                    <td>
                      <label for="resp_{{$vv['id']}}">% {{$vv['performance_percentage']}}</label> 
                       <meter id="resp_{{$vv['id']}}" value="{{$vv['performance_percentage'] / 100}}"></meter>
                     </td>
                     <td>
                          @if(!isset($vv['is_good']))
                            لم تحدد 
                            @elseif($vv['is_good'] == 1)
                            <span class="badge text-bg-success">سليم</span>
                            @elseif($vv['is_good'] == 0)
                            <span class="badge text-bg-warning">غير سليم</span>
                            @endif 
                        </td>
                        <td class="tdd">
                        @if(!isset($vv['is_good']) || $vv['is_good'] == 1)
                             لايوجد 
                         @elseif($vv['is_good'] == 0)
                          <div class="tdOptmodal">
                           <button type="button" data-bs-toggle="modal" data-bs-target="#modalsuper-{{$vv['id']}}"" class="btn btn-sm btn-dark">التفاصيل <i class="bi bi-eye-fill"></i></button>
                           <div class="modal fade" id="modalsuper-{{$vv['id']}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-1000px">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h3><i class="bi bi-eye-fill" style="color:#fff;font-size:1.3rem;"></i> التفاصيل</h3>
                                        <br>
                                    </div>
                                    <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
                                    <a href="#" class="fw-bold text-gray-900 btn btn-sm btn-info">التجهيزات</a><br><br>
                                        <ol type='I'>
                                        @foreach(explode('&',$vv['equipments']) as $e)
                                            <li>
                                                {{@\App\Models\Equipment::find($e)->title}}
                                            </li>
                                            @endforeach
                                        </ol>
                                        <br>
                                            <div>
                                            <a href="#" class="fw-bold text-gray-900 btn btn-sm btn-info">الملاحظات</a><br><br>
                                            <p>{{$vv['notes']}}</p>
                                        </div>
                                        <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                                        <input type="button" class="btn" data-bs-dismiss="modal" value="إلغاء" style="float:left;background:#F60F37;color:#fff;margin:0 10px;">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
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
                        <th class="min-w-5px">حالة التجهيزات</th>
                        <th class="min-w-5px">التجهيزات والملاحظات</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">
                @if(!empty($vv['researchers']))
                @foreach($vv['researchers'] as $vvv) 
                    <tr>
                    <td>{{$vvv['name']}}</td>
                    <td><span class="badge text-bg-info">{{$vvv['enrolled_date']}}</span></td>
                    <td>
                       <label for="resa_{{$vvv['id']}}">{{$vvv['accomplished_projects']}}</label> 
                        <progress id="resa_{{$vvv['id']}}" value="{{$vvv['accomplished_projects']}}" max="{{$count}}"></progress>
                    </td>
                    <td>
                      <label for="resp_{{$vvv['id']}}">% {{$vvv['performance_percentage']}}</label> 
                       <meter id="resp_{{$vvv['id']}}" value="{{$vvv['performance_percentage'] / 100}}"></meter>
                     </td>
                    <td>
                      @php 
                        @$eval = \App\Models\ProjectEvaluation::where([
                            'type_id' => 5 ,
                             'team_user_id' => $vvv['id'],
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
                         <td>
                            @if(!isset($vvv['is_good']))
                            لم تحدد 
                            @elseif($vvv['is_good'] == 1)
                            <span class="badge text-bg-success">سليم</span>
                            @elseif($vvv['is_good'] == 0)
                            <span class="badge text-bg-warning">غير سليم</span>
                            @endif
                        </td>
                        <td class="tdd">
                        @if(!isset($vvv['is_good']) || $vvv['is_good'] == 1)
                             لايوجد 
                         @elseif($vvv['is_good'] == 0)
                          <div class="tdOptmodal">
                           <button type="button" data-bs-toggle="modal" data-bs-target="#modalres-{{$vvv['id']}}"" class="btn btn-sm btn-dark">التفاصيل <i class="bi bi-eye-fill"></i></button>
                           <div class="modal fade" id="modalres-{{$vvv['id']}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-1000px">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h3><i class="bi bi-eye-fill" style="color:#fff;font-size:1.3rem;"></i> التفاصيل</h3>
                                        <br>
                                    </div>
                                    <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
                                    <a href="#" class="fw-bold text-gray-900 btn btn-sm btn-info">التجهيزات</a><br><br>
                                        <ol type='I'>
                                        @foreach(explode('&',$vvv['equipments']) as $e)
                                            <li>
                                                {{@\App\Models\Equipment::find($e)->title}}
                                            </li>
                                            @endforeach
                                        </ol>
                                        <br>
                                            <div>
                                            <a href="#" class="fw-bold text-gray-900 btn btn-sm btn-info">الملاحظات</a><br><br>
                                            <p>{{$vvv['notes']}}</p>
                                        </div>
                                        <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                                        <input type="button" class="btn" data-bs-dismiss="modal" value="إلغاء" style="float:left;background:#F60F37;color:#fff;margin:0 10px;">
                                        </div>
                                    </div>
                        </div>
                        @endif
                     </td>
                   </tr>
                   @endforeach
                   @endif
                </tbody>
            </table>
            @endforeach
            @endif
            @endforeach
          </div>
    </div>

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

@stop

@section('scripts')
<script>
  $("div.tdOpt button.btn-dark").on("click",function(){
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
</script>
@stop