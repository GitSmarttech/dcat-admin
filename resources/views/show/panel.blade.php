<div class="box-body">
    <div class="form-horizontal mt-1">
        @if($rows->isEmpty())
            @foreach($fields as $field)
                {!! $field->render() !!}
            @endforeach
        @else
            <div>
                @foreach($rows as $row)
                    {!! $row->render() !!}
                @endforeach
            </div>
        @endif
        <div class="clearfix"></div>
    </div>
    <div class="pull-right">
        <div class="view-edit-btn btn-group pull-right btn-mini" style="margin-right: 5px">
            <a href="{{$edit_url}}" class="btn btn-sm btn-primary">
                <i class="feather icon-edit-1"></i>
                <span class="d-none d-sm-inline">{{ trans('admin.edit') }}</span>
            </a>
        </div>
    </div>
</div>
