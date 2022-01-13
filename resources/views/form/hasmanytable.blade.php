<style>
    .table-has-many .input-group{flex-wrap: nowrap!important}
</style>

<div class="row form-group">
    <div class="{{$viewClass['label']}} "><label class="control-label pull-right">{!! $label !!}</label></div>
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')

        <span name="{{$column}}"></span> {{-- 用于显示错误信息 --}}

        <div class="has-many-{{$columnClass}}" >
            <table class="table table-has-many has-many-{{$columnClass}}">
                <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach

                    <th class="hidden"></th>

                    @if($options['allowDelete'])
                        <th></th>
                    @endif
                </tr>
                </thead>
                <tbody class="has-many-{{$columnClass}}-forms">
                @foreach($forms as $pk => $form)
                    <tr class="has-many-{{$columnClass}}-form fields-group">

                        <?php $hidden = ''; ?>

                        @foreach($form->fields() as $field)

                            @if (is_a($field, Dcat\Admin\Form\Field\Hidden::class))
                                <?php $hidden .= $field->render(); ?>
                                @continue
                            @endif

                            <td>{!! $field->setLabelClass(['hidden'])->width(12, 0)->render() !!}</td>
                        @endforeach

                        <td class="hidden">{!! $hidden !!}</td>

                        @if($options['allowDelete'])
                            <td class="form-group">
                                <div>
                                    <div class="remove btn btn-white btn-sm pull-right"><i class="feather icon-trash"></i></div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>

            <template class="{{$columnClass}}-tpl">
                <tr class="has-many-{{$columnClass}}-form fields-group">

                    {!! $template !!}

                    <td class="form-group">
                        <div>
                            <div class="remove btn btn-white btn-sm pull-right"><i class="feather icon-trash"></i></div>
                        </div>
                    </td>
                </tr>
            </template>

            @if($options['allowCreate'])
                <div class="form-group row m-t-10">
                    <div class="{{$viewClass['field']}}" style="margin-top: 8px">
                        <div class="add btn btn-primary btn-outline btn-sm"><i class="feather icon-plus"></i>&nbsp;{{ trans('admin.new') }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{--<hr style="margin-top: 0px;">--}}

<script>
    var nestedIndex = {!! $count !!},
        container = '.has-many-{{ $columnClass }}';

    function replaceNestedFormIndex(value) {
        return String(value).replace(/{{ Dcat\Admin\Form\NestedForm::DEFAULT_KEY_NAME }}/g, nestedIndex);
    }
    var addEleBtn='.has-many-{{ $columnClass }} .add'
    $(addEleBtn).eq(0).on('click',  function () {
        console.log(222)
        var tpl = $('template.{{ $columnClass }}-tpl');

        nestedIndex++;
        var template = replaceNestedFormIndex(tpl.html());

        $('.has-many-{{ $columnClass }}-forms').append(template);
        $('.has-many-{{ $columnClass }}-forms').children('tr:last-child').children('td').eq(2).find('.field_password_').eq(0).removeAttr('readonly')
        $('.has-many-{{ $columnClass }}-forms').children('tr:last-child').children('td').eq(3).find('.field_new_password_').eq(0).attr('readonly',"readonly")
        $('.has-many-{{ $columnClass }}-forms').children('tr:last-child').children('td').eq(3).find('.field_new_password_').eq(0).attr('hidden',"true")
        $('.has-many-{{ $columnClass }}-forms').children('tr:last-child').children('td').eq(3).find('.field_new_password_').eq(0).val('new');
        if($('.has-many-{{ $columnClass }}-forms').children('tr:last-child').children('td').eq(3).find('.field_new_password_').length !== 0){
            var inputEle=$('.has-many-{{ $columnClass }}-forms').children('tr:last-child').children('td').eq(3).find('.input-group').eq(0)
            var inputHtml=`<input build-ignore="1" type="password" value="" class="form-control field_port_agency_account_ field_new_password_ field_new_password" placeholder="Input New Password" readonly="readonly">`
            inputEle.append(inputHtml)
        }
    });
    {{--$(container).on('click', '.add', function () {--}}
    {{--    var tpl = $('template.{{ $columnClass }}-tpl');--}}

    {{--    nestedIndex++;--}}

    {{--    var template = replaceNestedFormIndex(tpl.html());--}}

    {{--    $('.has-many-{{ $columnClass }}-forms').append(template);--}}
    {{--});--}}

    $(container).on('click', '.remove', function () {
        var $form = $(this).closest('.has-many-{{ $columnClass }}-form');

        $form.hide();
        $form.find('[required]').prop('required', false);
        $form.find('.{{ Dcat\Admin\Form\NestedForm::REMOVE_FLAG_CLASS }}').val(1);
    });
</script>

