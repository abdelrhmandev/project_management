<div class="col-lg-12">
   <div class="card h-md-100 tab-pane">
       <div class="card-header py-5">
           <h3 class="card-title align-items-start flex-column">
               <span class="card-label fw-bold text-dark">البلاغات {{ $RedFlagsCount }}</span>
           </h3>
           <button type="button" data-bs-toggle="modal" data-bs-target="#ClientmodalWrapRedFlag" id="addRedFlagBtn" class="btn btn-sm me-2 btn-primary"><i class="bi bi-plus-square"></i>إنشاء بلاغ جديد</i></button>
       </div>
       <div class="card-body px-0 pt-7">
           @if($RedFlagsCount)
           <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7">
               <thead>                                    
                   <tr class="fw-semibold fs-7 text-white border-bottom border-gray-200 py-4 bg-danger">
                       <th>&nbsp;</th>
                       <th>البلاغ</th>
                       <th>حاله البلاغ</th>
                       <th>الرد</th>
                       <th>&nbsp;</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($RedFlags as $RedFlag)
                        <tr class="py-5 fw-semibold  border-bottom border-gray-300">
                            <td>&nbsp;</td>
                            <td>
                                {{ $RedFlag->title }}
                                <p>{{ \Carbon\Carbon::parse($RedFlag->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($RedFlag->created_at)->diffForHumans() }}</p>
                            </td>
                            <td>                                       
                                @if($RedFlag->status == 'inprogress')
                                <span class="svg-icon svg-icon-1 svg-icon-success">
                                    <i class="fa-solid fa-spinner fa-spin fa-2xl"></i>
                                </span> 
                                جار مراجعه البلاغ  
                                @elseif($RedFlag->status == 'new')
                                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                   <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                   <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                   </svg>
                                   </span>
                                   بلاغ جديد وسيتم الرد عليكم قريباً 
                                @else
                                <span class="svg-icon svg-icon-1 svg-icon-success">
                                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                       <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
                                   </svg>
                                </span>     
                                سيتم الرد قريباً عليكم  
                                @endif
                            </td>
                            <td>
                                @if($RedFlag->type == 'approved')
                                    @foreach ($RedFlag->replies as $re)
                                        @if ($re === $RedFlag->replies->last())
                                            <div class="alert alert-dismissible bg-light-success">  
                                                {!! $re->reply  . \Carbon\Carbon::parse($re->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($re->created_at)->diffForHumans()  !!}
                                                @if (count($RedFlag->attachments))
                                                @foreach ($RedFlag->attachments as $Rfile)
                                                    @php
                                                        $Extension = \File::extension($Rfile->file);
                                                        $supported_image = ['gif', 'jpg', 'jpeg', 'png'];
                                                    @endphp
                                                    @if (in_array($Extension, $supported_image))
                                                        <a data-fslightbox="lightbox-basic" href="{{ asset('storage/' . $Rfile->file) }}">
                                                            <img data-dz-thumbnail="" src="{{ asset('storage/' . $Rfile->file) }}" width="50px" height="50px">
                                                        </a>
                                                    @else
                                                        <a class="" href="{{ asset('storage/' . $Rfile->file) }}">
                                                            <img data-dz-thumbnail="" alt="{{ asset('storage/' . $Rfile->file) }}" src="{{ asset('assets/media/svg/files/' . $Extension . '.svg') }}" width="50px" height="50px">
                                                        </a>
                                                    @endif
                                                @endforeach
                                                @else
                                                <p class="text-danger">    
                                                لا توجد مرفقات ارفقها مدير المشروع
                                                </p>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                           </td>
                       </tr>
                    @endforeach
               </tbody>
            </table>
            @else
            <div class="flex-equal fs-5 me-5">
                <div class="alert alert-danger" role="alert">
                    لا توجد بلاغات جديدة لهذا المشروع
                </div>
            </div>                            
            @endif
        </div>
    </div>
</div>