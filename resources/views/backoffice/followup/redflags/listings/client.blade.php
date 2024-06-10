<div class="tab-pane fade" id="kt_project_redflags_tab" role="tabpanel">
    <div class="col-lg-12">
        <div class="card h-md-100 tab-pane">
            <div class="card-header py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">البلاغات {{ $RedFlagsCount }}</span>
                </h3>
            </div>
            <div class="card-body px-0 pt-7">
                @if ($RedFlagsCount)
                    <table id="kt_datatable_both_scrolls" class="table-striped table-row-bordered gy-5 gs-7 table">
                        <thead>
                            <tr class="fw-semibold fs-7 border-bottom bg-danger border-gray-200 py-4 text-white">
                                <th>&nbsp;</th>
                                <th>البلاغ</th>
                                <th>مرفقات البلاغ</th>                              
                                <th>رد المدير العام </th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($RedFlags as $RedFlag)
                                <tr class="fw-semibold border-bottom border-gray-300 py-5">
                                    <td>&nbsp;</td>
                                    <td>
                                         {{ $RedFlag->title }}
                                         <p>{{ \Carbon\Carbon::parse($RedFlag->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($RedFlag->created_at)->diffForHumans() }}</p>
                                    </td>
                                    <td>
                                        @if (count($RedFlag->attachments))
                                            @foreach ($RedFlag->attachments as $Rfile)
                                                @php 
                                                $Extension = \File::extension($Rfile->file); 
                                                $supported_image = array('gif','jpg','jpeg','png');
                                                @endphp

                                                @if(in_array($Extension, $supported_image))
                                                <a data-fslightbox="lightbox-basic" href="{{ asset('storage/'.$Rfile->file) }}">
                                                    <img data-dz-thumbnail="" src="{{ asset('storage/'.$Rfile->file) }}" width="50px" height="50px">
                                                </a>
                                                @else                                                               
                                                <a class="" href="{{ asset('storage/' . $Rfile->file) }}">
                                                    <img data-dz-thumbnail="" alt="{{ asset('storage/' . $Rfile->file) }}" src="{{ asset('assets/media/svg/files/' . $Extension . '.svg') }}" width="50px" height="50px">
                                                </a>
                                                @endif



                                            @endforeach
                                        @else
                                            لا توجد مرفقات للبلاغ
                                        @endif
                                    </td>

                                    <td>
                                        @if ($RedFlag->status == 'new')
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalWrapPMRedFlagReply" id="{{ $RedFlag->id }}" data-red-id="{{ $RedFlag->id }}" data-client-id="{{ $RedFlag->client_id }}" data-red-title="{{ $RedFlag->title }}" class="btn btn-success AddRedFlagReplyClass"><i class="fa-sharp fa-regular fa-comment"></i>رد مدير المشروع</button>
                                        @else
                                            <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                    <path
                                                        d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                        fill="currentColor" />
                                                    <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                                </svg>
                                            </span>
                                            تم الرد علي ا لعميل
                                        @endif
                                    </td>
                                    <td>

                                        @if ($RedFlag->status == 'done' && $RedFlag->type == 'approved')
                                            البلاغ مقبول و الادارة سوف ترد عليكم قريبا
                                        @endif
                                        @if ($RedFlag->type == 'rejected')
                                        <p class="text-danger">
                                            حاله البلاغ :  مرفوض من المدير العام  
                                        </p>
                                            @foreach ($RedFlag->replies as $Rfile)
                                                    @if($Rfile->reply_user_id == 1)

                                                        

                                                    
                                                        {{ $Rfile->reply}}
                                                        <p>{{ \Carbon\Carbon::parse($Rfile->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($Rfile    ->created_at)->diffForHumans() }}</p>
                                                        <p><button type="button" data-bs-toggle="modal" data-bs-target="#modalWrapClientFlagReplyAdmin" id="{{ $RedFlag->id }}" data-red-id="{{ $RedFlag->id }}" data-client-id="{{ $RedFlag->client_id }}" data-red-title="{{ $RedFlag->title }}" class="btn btn-info Client-redflag-ReplyAdminClass"><i class="fa-sharp fa-regular fa-comment"></i>رد العميل علي المدير العام</button></p>
                                                   
                                                        
                                                        
                                                        @forelse ($RedFlag->getReplyAttachments as $Rfile)
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

                                                        @empty
                                                        sdas
                                                        @endforelse
                                                   
                                                        @endif
                                            @endforeach
                                        @endif

                                        
                                        </td>
                                    <td>&nbsp;</td>
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
</div>