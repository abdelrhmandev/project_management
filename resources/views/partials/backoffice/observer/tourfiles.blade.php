@if(count($project_tour_files->where('file_type', 'img')) > 0)
<div class="col-xl-12">
    <div class="card card-xl-stretch mb-xl-8">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">صور للجولة الإستكشافية</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                    <div class="table-responsive">
                        <!--begin::Input group-->
                        <div class="fv-row">
                            <!--begin::Dropzone-->
                            <div class="dropzone" id="kt_tour_img">
                                @foreach($project_tour_files->where('file_type', 'img') as $project_tour_file)
                                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                    <div class="dz-image">
                                        <a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ asset('storage/'.$project_tour_file->file) }}">
                                            <img data-dz-thumbnail="" alt="{{ asset('storage/'.$project_tour_file->file) }}" src="{{ asset('storage/'.$project_tour_file->file) }}" width="120px" height="120px">
                                        </a>
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
                                </div>
                                @endforeach
                            </div>
                            <!--end::Dropzone-->
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(count($project_tour_files->where('file_type', 'video')) > 0)
<div class="col-xl-12">
    <div class="card card-xl-stretch mb-xl-8">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">فيديوهات الجولة الإستكشافية</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                    <div class="table-responsive">
                        <!--begin::Input group-->
                        <div class="fv-row">
                            <!--begin::Dropzone-->
                            <div class="dropzone" id="kt_tour_video">
                                @foreach($project_tour_files->where('file_type', 'video') as $project_tour_file)
                                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                    <div class="dz-image">
                                        <img data-dz-thumbnail="" alt="1" src="{{ asset('assets/media/svg/files/'.\File::extension(asset('storage/' . $project_tour_file->file)).'.svg') }}" width="120px" height="120px">
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
                                </div>
                                @endforeach
                            </div>
                            <!--end::Dropzone-->
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(count($project_tour_files->where('file_type', 'file')) > 0)
<div class="col-xl-12">
    <div class="card card-xl-stretch mb-xl-8">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">خطابات/وثائق الجولة الإستكشافية</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                    <div class="table-responsive">
                        <!--begin::Input group-->
                        <div class="fv-row">
                            <!--begin::Dropzone-->
                            <div class="dropzone" id="kt_tour_file">
                                @foreach($project_tour_files->where('file_type', 'file') as $project_tour_file)
                                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                    <div class="dz-image">
                                        <a href="{{ asset('storage/'.$project_tour_file->file) }}">
                                            <img class="py-2" data-dz-thumbnail="" alt="1" src="{{ asset('assets/media/svg/files/'.\File::extension(asset('storage/' . $project_tour_file->file)).'.svg') }}" width="120px" height="120px">
                                        </a>
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
                                </div>
                                @endforeach
                            </div>
                            <!--end::Dropzone-->
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif