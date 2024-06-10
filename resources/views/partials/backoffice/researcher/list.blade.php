<div class="scroll-y me-n5 pe-5 h-600px h-xl-auto" id="researcherlist" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">

    @if (isset($selected_researchers))
    @foreach ($selected_researchers as $selected_researcher)
    <div class="mb-2">
        <label id="mylist" class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center mr-12" for="kt_select_researcher . {{ $selected_researcher->team_user_id }}">
            <input type="checkbox" class="form-check-input" name="selected_researcher_id[]" value="{{ $selected_researcher->team_user_id }}" id="kt_select_researcher . {{ $selected_researcher->team_user_id }}" checked />
            <div class="ms-4">
                <span class="fs-6 fw-bold text-gray-900">{{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->name ?? '' }}<span class="fs-6 fw-semibold text-gray-900"> - تاريخ الإنضمام
                        {{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->enrolled_date ?? '' }}</span></span>
                <div class="fw-semibold fs-7 text-muted text-start">
                    {{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->performance_percentage ?? '' }}%<span class="fs-6 fw-semibold text-success-900"> - أنهى
                        {{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->accomplished_projects ?? '' }}
                        مشروع/مشاريع</span>
                </div>
            </div>
        </label>
    </div>
    <div class="separator separator-dashed d-none mt-4"></div>
    @endforeach
    @endif

    @if (isset($selected_attracting_teams))
    @foreach ($selected_attracting_teams as $selected_attracting_team)
    <div class="mb-2" id="newResearcherlist">
        <label id="mylist" class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center mr-12" for="kt_select_researcher . {{ $selected_attracting_team->id }}">
            <input type="checkbox" class="form-check-input" name="researcher_id[]" value="{{ $selected_attracting_team->id }}" id="kt_select_researcher . {{ $selected_attracting_team->id }}" />
            <div class="ms-4">
                <span class="fs-6 fw-bold text-gray-900">{{ $selected_attracting_team->name }}<span class="fs-6 fw-semibold text-gray-900"> - تاريخ الإنضمام
                        {{ $selected_attracting_team->enrolled_date }}</span></span>
                <div class="fw-semibold fs-7 text-muted text-start">
                    {{ $selected_attracting_team->performance_percentage }}%<span class="fs-6 fw-semibold text-success-900"> - أنهى
                        {{ $selected_attracting_team->accomplished_projects }} مشروع/مشاريع</span>
                </div>
            </div>
        </label>
    </div>
    <div class="separator separator-dashed d-none mt-4"></div>
    @endforeach
    @endif
</div>