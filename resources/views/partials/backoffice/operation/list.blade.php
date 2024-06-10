@foreach ($rows as $row)
    <div class="col-md-6 col-xl-4">
        <a href="{{ $row->status->id == 3 ? route($resource . '.edit', $row->id) : url('project/followup/' . $row->id) }}"
            class="card border-hover-primary">
            <div class="card-header border-0 pt-9">
                <div class="card-title m-0">
                    <div class="symbol symbol-50px w-50px bg-light">
                        <img src="{{ asset('storage/' . $row->logo) }}" alt="{{ $row->title }}" class="p-3" />
                    </div>
                </div>
                <div class="card-toolbar">
                    <span class="badge badge-{{ $row->status->class }} fw-bold me-auto px-4 py-3">{{ $row->status->trans }}</span>
                </div>
            </div>
            <div class="card-body p-9">
                <div class="fs-3 fw-bold text-dark">{{ $row->title }}</div>
                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">إجمالي العدد:
                    {{ $row->cases_count ?? $row->EmpowerCharity->charity_count ?? $row->building_count }}</p>
                <div class="d-flex flex-wrap mb-5">
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                        <div class="fs-6 text-gray-800 fw-bold">{{ $row->start_date ?? '-' }}</div>
                        <div class="fw-semibold text-gray-400">{{ __('project.start_date') }}</div>
                    </div>
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                        <div class="fs-6 text-gray-800 fw-bold">{{ $row->end_date ?? '-' }}</div>
                        <div class="fw-semibold text-gray-400">{{ __('project.end_date') }}</div>
                    </div>
                </div>
                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                    title="تم إنجاز ما يقارب {{ $row->progress_bar }}% من المشروع">
                    <div class="bg-primary rounded h-4px" role="progressbar" style="width:{{ $row->progress_bar }}%"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </a>
        @if ($row->status->id == 1 && Auth::user()->hasRole('project'))
            <br />
            <button type="button" id="{{ $row->id }}" data-id="{{ $row->id }}" class="btn btn-success btn-sm edit-project-url">{{ __('project.edit') }}</button>
        @endif
        @if (Auth::user()->hasRole('admin'))
        <br />
        <form action="{{ route('projects.destroy',$row->id)}}" method="post">
            @method('DELETE')
            @csrf
        <button type="submit" id="{{ $row->id }}" data-id="{{ $row->id }}" class="btn btn-danger btn-sm delete-project-btn">{{ __('project.delete') }}</button>
        </form>
        @endif
    </div>
@endforeach
<div class="d-flex flex-stack flex-wrap pt-10">
    {!! $rows->links() !!}
</div>
