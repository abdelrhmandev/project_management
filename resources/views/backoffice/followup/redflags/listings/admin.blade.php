<div class="tab-pane fade" id="kt_project_redflags_tab" role="tabpanel">
    <div class="col-lg-12">
        <div class="card h-md-100 tab-pane">
            <div class="card-header py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">البلاغات التي قد تمت الرد عليها من قبل مدير المشروع {{ $RedFlagsCount }}</span>
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
                                <th>رد مدير المشروع</th>
                                <th>مرفقات رد مدير المشروع</th>
                                <th>رد المدير العام</th>
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
                                            لا توجد مرفقات للبلاغ
                                        @endif
                                    </td>
                                    <td>     
                                        @php $PMR = ''; @endphp                                
                                        @foreach ($RedFlag->replies as $re)
                                            @if ($re->reply_user_id == 2)
                                                @php $PMR.= $re->reply . '<p>' . \Carbon\Carbon::parse($re->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($re->created_at)->diffForHumans() . '</p>'; @endphp
                                                {!! $re->reply . '<p>' . \Carbon\Carbon::parse($re->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($re->created_at)->diffForHumans() . '</p>' !!}
                                            @endif
                                        @endforeach
                                         
                                    </td>
                                    <td>
                                        @if (count($RedFlag->getReplyAttachments))
                                            @foreach ($RedFlag->getReplyAttachments as $Rfile)
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
                                            لا توجد مرفقات ارفقها مدير المشروع
                                        @endif
                                    </td>
                                    <td>
                                        @if($RedFlag->status == 'done' && $RedFlag->type == 'approved')
                                        <p class="text-success">تمت الموافقة على رد مدير المشروع</p>
                                        @elseif($RedFlag->type == 'rejected')
                                        <p class="text-danger">تم الرفض على رد مدير المشروع</p>
                                        @else
                                                <button type="button" data-bs-toggle="modal" 
                                                data-bs-target="#modalWrapRedFlagReply" id="{{ $RedFlag->id }}" 
                                                data-redflag-id="{{ $RedFlag->id }}" 
                                                data-client-id="{{ $RedFlag->client_id }}" 
                                                data-redflag-title="{{ $RedFlag->title }}" 
                                                data-project-manager-redflag-Reply="{!! $PMR ?? '' !!}" 
                                                class="btn btn-primary AdminRedFlagReplyPMClass"><i class="fa-solid fa-comment-quote fa-comment"></i>رد المدير العام علي مدير المشروع</button>
                                           
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
                            لا توجد بلاغات مردود عليها من قبل مدير المشروع لهذا المشروع
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
