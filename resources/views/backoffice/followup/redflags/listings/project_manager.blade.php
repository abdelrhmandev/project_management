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
                                <th>المرفقات</th>                                                         
                                <th>رد مدير المشروع</th>
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
                                            @php $attachments = ''; @endphp
                                            @foreach ($RedFlag->attachments as $Rfile)
                                                @php
                                                    $Extension = \File::extension($Rfile->file);
                                                    $supported_image = ['gif', 'jpg', 'jpeg', 'png'];
                                                @endphp
                                                @if (in_array($Extension, $supported_image))
                                                    <a data-fslightbox="lightbox-basic" href="{{ asset('storage/' . $Rfile->file) }}">
                                                        <img data-dz-thumbnail="" src="{{ asset('storage/' . $Rfile->file) }}" width="50px" height="50px">
                                                    </a>
                                                    @php $attachments.= "<a data-fslightbox=\"lightbox-basic\" href=\"".asset('storage/' . $Rfile->file)."\">
                                                        <img data-dz-thumbnail=\"".asset('storage/' . $Rfile->file)."\" src=\"\" width=\"50px\" height=\"50px\"></a>";
                                                    @endphp
                                                @else
                                                    <a class="" href="{{ asset('storage/' . $Rfile->file) }}"><img data-dz-thumbnail="" alt="{{ asset('storage/' . $Rfile->file) }}" src="{{ asset('assets/media/svg/files/' . $Extension . '.svg') }}" width="50px" height="50px"></a>
                                                    @php 
                                                        $attachments.= "<a target=\"_blank\" class=\"\" href=\"".asset("storage/". $Rfile->file)."\"><img data-dz-thumbnail=\"\" src=\"".asset("assets/media/svg/files/".$Extension.'.svg')."\" width=\"50px\" height=\"50px\"></a>";
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td style="vertical-align:middle;">
                                        @if($RedFlag->status == 'inprogress' && $RedFlag->type != 'rejected')
                                        تم الرد 
                                        @elseif($RedFlag->status == 'new')
                                        <button type="button" style="" class="btn btn-sm btn-success me-2" data-redflag-attachments="{{ $attachments ?? ' لا توجد مرفقات للبلاغ ' }} " data-bs-toggle="modal" data-bs-target="#modalWrapPMRedFlagReplyClient" id="{{ $RedFlag->id }}" data-redflag-id="{{ $RedFlag->id }}" data-client-id="{{ $RedFlag->client_id }}" data-redflag-title="{{ $RedFlag->title }}" class="btn btn-success PMRedFlagReplyClientClass"><i class="fa-sharp fa-regular fa-comment"></i>إضافة الرد</button>
                                        @endif
                                        @if($RedFlag->type == 'rejected')
                                            <p class="text-danger">المدير العام رفض البلاغ</p> 
                                                @php $PMR = ''; @endphp                                
                                                    @foreach ($RedFlag->replies as $re)
                                                        @if ($re->reply_user_id == 1)
                                                            @php $PMR.= $re->reply . '<p>' . \Carbon\Carbon::parse($re->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($re->created_at)->diffForHumans() . '</p>'; @endphp
                                                        @endif
                                                    @endforeach                  
                                            <button type="button" style="padding:5px 10px !important;" data-bs-toggle="modal" data-bs-target="#modalWrapPMRedFlagReplyAdmin" id="{{ $RedFlag->id }}" data-redflag-reply="{{ $PMR ?? '' }}" data-type="replied" data-redflag-id="{{ $RedFlag->id }}" data-client-id="{{ $RedFlag->client_id }}" data-redflag-title="{{ $RedFlag->title }}" class="btn btn-info PMRedFlagReplyAdminClass"><i class="fa-sharp fa-regular fa-comment"></i>الرد على البلاغ المرفوض</button>                                        
                                        @endif
                                    </td>
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