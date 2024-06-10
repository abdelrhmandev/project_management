@if(isset($team_ranks_items))
@foreach($team_ranks_items as $team_ranks_item)
<div written-repeater-item>
    <div class="form-group row text-center">
        <div class="fv-row w-100 flex-md-root">
            <label class="required form-label">{{ __('equipment.contract-term') }}</label>
            <input type="text" class="form-control mb-2 w-540px" value="{{ $team_ranks_item->title }}" name="written-contract-term[{{ $team_ranks_item->id }}]" />
        </div>
        <div class="col-md-4">
            <a href="javascript:deleteTeamRankItem({{$team_ranks_item->id}})" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8"><i class="la la-trash-o"></i>حذف</a>
        </div>
    </div>
</div>
@endforeach
@endif