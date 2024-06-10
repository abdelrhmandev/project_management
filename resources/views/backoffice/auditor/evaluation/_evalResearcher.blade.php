<div class="modal fade res" id="kt_modal_researcher" tabindex="-1" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered mw-1000px">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="fw-bold">تقييم الباحث</h2>
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
            <form id="evalForm" data-action="{{route('evalsResearcher')}}">
                @csrf
                <input type="hidden" name="project" value="{{$project}}">
                <input type="hidden" name="researcher" value="">

                <h5 class="mt-6">كيف تقيم الباحث ؟ </h5>
                <span class="rating"></span>
                <div class="checkWrapp">
                    @php $r = 1;  do { @endphp
                    <div class="rate">
                      <input type="radio" name="rating" value="{!!$r!!}">
                      <i class="bi bi-star" title="{!!$r!!}"></i>
                    </div> 
                    @php  $r++; } while($r <= 5) @endphp
                </div> 
                
                <span class="success"></span>
                <div class="text-center pt-6">
                    <button id="evalSend" type="button" class="btn btn-primary">ارسال</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                </div>
            </form>
        </div>
    </div>
</div> 