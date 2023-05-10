<div class="{{$viewClass['form-group']}} {{ $class }}" id="obs-{{$id}}">
    <label for="{{$column}}" class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        <div class="obs-file">
            <input type="file" class="obs-file-input" id="{{$id}}">
            <label class="obs-file-label" for="{{$class}}">选择文件</label>
            <ul class="file-list"></ul>
            <div class="obs-file-hidden-input"></div>
        </div>
        <div class="progress obs-progress">
            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 10%" aria-valuenow="10"
                 aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @include('admin::form.help-block')
    </div>
</div>
