@extends('layouts.app')

@section('style')
  <style>
  td.current {
    cursor:pointer;
  }
  td.current:hover {
    color:gray;
  }
  div#rej {
    display:none;
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
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-5px">اسم التجهيز</th>
                        <th class="min-w-5px">العدد</th>
                        <th class="min-w-125px">الملاحظات</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">
                @foreach($eq as $v)
                    <tr>
                    <td class="current" data-item="{{$v->EQID}}" data-project="{{$row->id}}" data-bs-toggle="modal" data-bs-target="#kt_modal_div_eq">{{$v->title}}</td>
                    <td>{{$v->amount}}</td>
                    <td>{{$v->notes}}</td>
                   </tr>
                   @endforeach
                </tbody>
            </table>
            @if($exist && is_null($isAgree) && ($isAgree != 1 || $isAgree != 0))
             <form action="{{route('divEQ.agreeornot')}}" method="post">
                    @error('reason')
                       <div class="alert alert-danger">{{"يجب ادخال سبب الرفض"}}</div>
                    @enderror
                @csrf 
                @method('PATCH')
                <input type="hidden" name="project" value="{{$row->id}}">
                <input class="btn btn-success" type="submit" name="agree" value="موافق">
                <input class="btn btn-danger rej" type="button" name="reject" value="رفض">
                <br><br>
                <div id="rej">
                    <textarea class="form-control" name="reason" placeholder="سبب الرفض" disabled></textarea><br>
                    <input class="btn btn-primary" type="submit" name="send" value="ارسال" style="padding:5px 12px;">
                </div>
            </form>
            @endif
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
var div = true;
$("input.rej").on("click",function(e){
  if(div){
  $("div#rej textarea").removeAttr("disabled");
  $("div#rej").slideDown();
  div = false;
  }else {
    $("div#rej textarea").attr({"disabled":true});
   $("div#rej").slideUp(); 
   div = true;
  }
});
</script>
@stop