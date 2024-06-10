<div class="scroll-y me-n5 pe-5 h-300px h-xl-auto" data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
    data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header"
    data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body"
    data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">

    @forelse ($observer_teams as $observer_team)
        <div class="mb-2">
            <!--begin::Option-->
            <label
                class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center form-check-label"
                for="kt_create_account_form_account_type_personal . {{ $observer_team->team_user_id }}">
                <input type="radio"
                    onClick="reloadResearcher({{ $observer_team->team_user_id }}, {{ $project_id }}, 'none')"
                    class="form-check-input" name="team_user_id" value="{{ $observer_team->superior_id }}"
                    id="kt_create_account_form_account_type_personal . {{ $observer_team->team_user_id }}" />
                <!--begin::Details-->
                <div class="ms-4">
                    <span
                        class="fs-6 fw-bold text-gray-900">{{ $attracting_teams->where('id', $observer_team->team_user_id)->first()->name }}</span>
                    <div class="fw-semibold fs-7 text-muted text-start">
                        {{ $attracting_teams->where('id', $observer_team->team_user_id)->first()->performance_percentage }}%
                        - الباحثين
                        {{ $observer_teams->where('superior_team_id', $observer_team->team_user_id)->count() }} /
                        {{ $observer_team->qty }}</div>
                </div>
                <!--end::Details-->
            </label>
        </div>
        <!--end::Option-->
        <!--begin::Separator-->
        <div class="separator separator-dashed d-none mt-4"></div>
        <!--end::Separator-->
    @empty
    <div class="mb-2">
        <!--begin::Option-->
 
            <!--begin::Details-->
            <div class="ms-4 text-danger">
                لا يوجد مشرفين
            </div>
            <!--end::Details-->
        </label>
    </div>
    @endforelse
</div>
