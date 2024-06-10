@if(isset($selected_researchers))
@foreach($selected_researchers as $selected_researcher)
<div class="mb-2">
    <label id="mylist" class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center mr-12" for="kt_selected_researcher . {{ $selected_researcher->team_user_id }}">
        <input type="checkbox" class="form-check-input" name="selected_researcher_checkbox[]" value="{{ $selected_researcher->team_user_id }}" id="kt_selected_researcher . {{ $selected_researcher->team_user_id }}" checked />
        <div class="ms-4">
            <span class="fs-6 fw-bold text-gray-900">{{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->name ?? ''}}<span class="fs-6 fw-semibold text-gray-900"> - تاريخ الإنضمام  {{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->enrolled_date ?? '' }}</span></span>
           
            @php 
                  $eval = \App\Models\ProjectEvaluation::where('team_user_id',$selected_researcher->team_user_id)->first()->evaluate ?? 0;
                   $e=1;
                   $ee=1;
                  @endphp
                <span class="fs-6 fw-semibold text-gray-900" style="display:inline-block;margin-right:25px;">
                    @while($e <= $eval)
                    <i class="bi bi-star-fill" style="color:orange;"></i>
                    @php $e++; @endphp
                    @endwhile

                    @while($ee <= (5 - $eval))
                    <i class="bi bi-star" style="color:orange;"></i>
                    @php $ee++; @endphp
                    @endwhile
                   
                </span>
           
            <div class="fw-semibold fs-7 text-muted text-start">{{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->performance_percentage ?? '' }}%<span class="fs-6 fw-semibold text-gray-900"> - أنهى  {{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->accomplished_projects ?? '' }} مشروع/مشاريع</span>
            @if($selected_researcher->received_train == '1')
            <span class="w-80px badge badge-light-success me-4">قد حضر التدريب</span>
            @else
            <span class="w-80px badge badge-light-danger me-4">لم يحضر التدريب</span>
            @endif
            </div>
        </div>
    </label>
</div>
<div class="separator separator-dashed d-none mt-4"></div>
<input type="hidden" class="form-check-input" name="selected_researcher_id[]" value="{{ $selected_researcher->team_user_id }}" id="kt_selected_researcher . {{ $selected_researcher->team_user_id }}"  />
@endforeach
@endif

@if(isset($selected_attracting_teams))
@foreach($selected_attracting_teams as $selected_attracting_team)
<div class="mb-2" id="newResearcherlist">
    <label id="mylist" class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center mr-12" for="kt_select_researcher . {{ $selected_attracting_team->id }}">
        <input type="checkbox" class="form-check-input" name="researcher_id[]" value="{{ $selected_attracting_team->id }}" id="kt_select_researcher . {{ $selected_attracting_team->id }}" />
        <div class="ms-4">
            <span class="fs-6 fw-bold text-gray-900">{{ $selected_attracting_team->name }}<span class="fs-6 fw-semibold text-gray-900"> - تاريخ الإنضمام  {{ $selected_attracting_team->enrolled_date }}</span></span>
            <div class="fw-semibold fs-7 text-muted text-start">{{ $selected_attracting_team->performance_percentage }}%
                <span class="fs-6 fw-semibold text-gray-900"> - أنهى  {{ $selected_attracting_team->accomplished_projects }} مشروع/مشاريع</span>
        
            @php 
                  $eval = \App\Models\ProjectEvaluation::where('team_user_id',$selected_attracting_team->id)->first()->evaluate ?? 0;
                   $e=1;
                   $ee=1;
                  @endphp
                <span class="fs-6 fw-semibold text-gray-900" style="display:inline-block;margin-right:25px;">
                    @while($e <= $eval)
                    <i class="bi bi-star-fill" style="color:orange;"></i>
                    @php $e++; @endphp
                    @endwhile

                    @while($ee <= (5 - $eval))
                    <i class="bi bi-star" style="color:orange;"></i>
                    @php $ee++; @endphp
                    @endwhile
                   
                </span>
        </div>
        </div>
    </label>
</div>
<div class="separator separator-dashed d-none mt-4"></div>
@endforeach
@endif
