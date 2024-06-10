<div class="modal fade res" id="kt_modal_div" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">
                    <img src="{{ asset('assets/media/training/vuesax-linear-command.png') }}" class="mx-2" alt="">تقسيم التجهيزات
                </h2>
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
                <form id="divForm" data-action="{{ route('e.Div') }}">
                    @csrf
                    <input type="hidden" name="project" value="{{ $project }}">
                    <input type="hidden" name="eqID" value="">
                    <input type="hidden" name="eqType" value="">
                    <input type="hidden" name="eqQty" value="">
                    <input type="hidden" name="status" value="">
                    <div class="divWrap">
                        <div>
                            <span class="observer"></span>
                            <select class="form-select" name="observer">
                                <option value="-1">إختر اسم المشرف</option>
                                @foreach (\App\Models\ProjectObserverTeam::select('team_user_id')->where('project_id', $project)->where('type_id', '4')->get() as $v)
                                    <option value="{{ $v->team_user_id }}">{{ \App\Models\AttractingTeam::find($v->team_user_id)->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <span class="amount"></span>
                            <input type="number" class="form-control" name="amount" placeholder="الكمية">
                        </div>
                        <div>
                            <h5>الكمية المتبقية</h5>
                            <h5 name="remain">-----</h5>
                        </div>
                    </div>

                    <div>
                        <span class="notes"></span>
                        <textarea class="form-control" rows="8" name="notes" placeholder="اي ملاحظة؟"></textarea>
                    </div>
                    <br>
                    <span class="files"></span>
                    <div class="dropzone" id="kt_div_eq_files">
                        <div class="wrapperdz">
                            @php
                            $eqFiles = $project_equipments_files->where('equipment_type',$equipment_type)->where('user_id', \Auth::user()->id)->first()->file ?? ""; 
                            @endphp
                            @if(isset($eqFiles) && $eqFiles !="" )
                            @php $files = explode("&&",$eqFiles); @endphp
                            @foreach($files as $project_equipment_file)

                            @if(isset($project_equipment_file) && !is_null($project_equipment_file) && $project_equipment_file !="")
                            <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" data-file='{{$project_equipment_file}}'>
                                <div class="dz-image">
                                    @if(pathinfo(asset('storage/' . $project_equipment_file), PATHINFO_EXTENSION) == 'pdf')
                                    <a href="{{ asset('storage/'.$project_equipment_file) }}">
                                        <img class="py-2" data-dz-thumbnail="" alt="1" src="{{ asset('assets/media/svg/files/'.\File::extension(asset('storage/' . $project_equipment_file)).'.svg') }}" width="120px" height="120px">
                                    </a>
                                    @else
                                    <a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ asset('storage/'.$project_equipment_file) }}">
                                        <img data-dz-thumbnail="" alt="{{ asset('storage/'.$project_equipment_file) }}" src="{{ asset('storage/'.$project_equipment_file) }}" width="120px" height="120px">
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
                                <a class="dz-remove" href="javascript:deleteProjectEquipmentFile('{{$project_equipment_file}}',{{$row->id}},{{$equipment_type}})" data-dz-remove="">Remove file</a>
                            </div>
                            @endif
                            @endforeach
                            @endif
                        </div>
                        
                        <div class="dz-message needsclick">
                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                            <div class="ms-4">
                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">يمكنك رفع الملفات هنا</h3>
                                <span class="fs-7 fw-semibold text-gray-400">عدد الملفات المسموح به 10 ملفات</span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <span class="success"></span>
                    <div class="pt-6 text-center">
                        <button id="divSend" type="button" class="btn btn-primary mx-4">تقسيم</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
