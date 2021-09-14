<div class="{{$viewClass['form-group']}}">

    <div  class="{{ $viewClass['label'] }} control-label">
        <span>{!! $label !!}</span>
    </div>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')
        <input type="hidden" name="{{$name}}"/>
        @foreach($options as $select => $option)
        <label class="radio_label_admin {{ Dcat\Admin\Support\Helper::equal($select, $value) ?'active':'' }}"><input class="{{ Dcat\Admin\Support\Helper::equal($select, $value) ?'checked':'' }}" name="{{$name}}" {{ Dcat\Admin\Support\Helper::equal($select, $value) ?'checked':'' }} type="radio" value="{{$select}}" />{{$option}}</label>
        @endforeach

        @include('admin::form.help-block')

    </div>
</div>

{{--@include('admin::form.select-script')--}}
<script>
$(".radio_label_admin input").click(function () {
    $('.radio_label_admin').removeClass('active')
    $('.radio_label_admin input').removeClass('checked')
    $(this).parent('.radio_label_admin').addClass('active')
    $(this).addClass('checked')
})
</script>
