@foreach ($teamMembers as $v)
<div class="card card-xl-stretch tab-pane memb">
    <div class="card-header cursor-pointer pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">
                {{ $v->name }}
            </span>
        </h3>
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table align-middle gs-0 gy-3 fw-bold wmemb">
                <tr>
                    <td class="img">
                        <img src="{{ asset('assets/media/team/vuesax-linear-profile.png') }}"
                            alt="">
                    </td>
                    <td>
                        <span>الدور</span>
                        <p>{{\App\Models\TeamRankType::find($v->type)->trans }}</p>
                    </td>
                    <td class="img">
                        <img src="{{ asset('assets/media/team/vuesax-linear-user-square.png') }}"
                            alt="">
                    </td>
                    <td>
                        <span>رقم الهوية</span>
                        <p>{{ $v->national_id }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="img">
                        <img src="{{ asset('assets/media/team/vuesax-linear-teacher.png') }}"
                            alt="">
                    </td>
                    <td>
                        <span>المؤهل الدراسى</span>
                        <p>{{ @\App\Models\Qualification::find($v->qualification_id)->title }}</p>
                    </td>
                    <td class="img">
                        <img src="{{ asset('assets/media/team/vuesax-linear-briefcase.png') }}"
                            alt="">
                    </td>
                    <td>
                        <span>المهنة</span>
                        <p>{{ $v->occupation }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endforeach

<div id="pager">
{{$teamMembers->links()}}
</div>