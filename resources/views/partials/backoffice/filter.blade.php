<div class="me-4">
    <select id="status" name="status" data-control="select2" data-hide-search="true" class="form-select form-select-sm bg-body border-body fw-bold w-225px">
        <option value="0">{{ __('site.all') }}</option>
        @forelse($status as $value)
        @if (Auth::user()->hasRole('project'))
        <option value="{{ $value->id }}">{{ $value->trans }}</option>
        @else
        @if($value->id > 1)
        <option value="{{ $value->id }}">{{ $value->trans }}</option>
        @endif
        @endif
        @empty
        <option>{{ __('site.not_data') }}</option>
        @endforelse
    </select>
</div>

<div class="me-4">
    <input type="search" id="projectFilter" placeholder="{{ $placeholder ?? trans('site.search') }}" style="outline:none;border:none;padding:6px 20px;width:20rem" class="form-control">
</div>