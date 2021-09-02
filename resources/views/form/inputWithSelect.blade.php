<div class="{{$viewClass['form-group']}}">

    <div class="{{$viewClass['label']}} control-label">
        <span>{!! $label !!}</span>
    </div>

    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        <div class="row test-item-input">
            <div class="col-md">

                <div class="input-group">

                    @if ($prepend)
                        <span class="input-group-prepend"><span class="input-group-text bg-white">{!! $prepend !!}</span></span>
                    @endif
                    <input {!! $attributes !!} />

                    @if ($append)
                        <span class="input-group-append">{!! $append !!}</span>
                    @endif
                </div>

            </div>
            <div class="model-select-box">
                <input type="hidden" name="{{$select_name}}" value="{{$selectValue}}"/>
                <div class="model-select-text" value=""> {{$selectLabe}}</div>
                <b class="bg1"></b>
                <ul class="model-select-option">
                    @foreach($options as $select => $option)
                        <li data-option="{{$select}}" class="{{ Dcat\Admin\Support\Helper::equal($select, $selectValue) ?'selected':'' }}">{{$option}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @include('admin::form.help-block')
    </div>
</div>

<script>
    $(function () {
        /*
         * 模拟网页中所有的下拉列表select
         */
        function selectModel() {
            var $box = $('div.model-select-box');
            var $option = $('ul.model-select-option', $box);
            var $txt = $('div.model-select-text', $box);
            var speed = 10;
            var $bg = $('b.bg1',$box)


            // 点击小三角
            $bg.click(function(){
                $option.not($(this).siblings('ul.model-select-option')).slideUp(speed, function () {
                });
                $(this).siblings('ul.model-select-option').slideToggle(speed, function () {
                    // int($(this));
                });
                return false;
            })
            /*
             * 单击某个下拉列表时，显示当前下拉列表的下拉列表框
             * 并隐藏页面中其他下拉列表
             */
            $txt.click(function (e) {
                $option.not($(this).siblings('ul.model-select-option')).slideUp(speed, function () {
                });
                $(this).siblings('ul.model-select-option').slideToggle(speed, function () {
                    // int($(this));
                });
                return false;
            });
            //点击选择，关闭其他下拉
            /*
             * 为每个下拉列表框中的选项设置默认选中标识 data-selected
             * 点击下拉列表框中的选项时，将选项的 data-option 属性的属性值赋给下拉列表的 data-value 属性，并改变默认选中标识 data-selected
             * 为选项添加 mouseover 事件
             */
            $option.find('li').each(function(index,element){
                // console.log($(this) + '1');
                if($(this).hasClass('selected')){
                    $(this).parent('.model-select-option').siblings('.model-select-text').text($(this).text())
                }

                $(this).mousedown(function(){
                    $(this).parent().siblings('div.model-select-text').text($(this).text())
                        .attr('value', $(this).attr('data-option'));

                    $(this).parent().siblings('input[name="{{$select_name}}"]').text($(this).text())
                        .attr('value', $(this).attr('data-option'));

                    $option.slideUp(speed, function () {
                    });
                    $(this).addClass('selected').siblings('li').removeClass('selected');
                    return false;
                })

                $(this).on('mouseover',function(){
                    $(this).addClass('selected').siblings('li').removeClass('selected');
                })
            })
            //点击文档，隐藏所有下拉
            $(document).click(function (e) {
                $option.slideUp(speed, function () {
                });
            });

        }

        selectModel();
    })
</script>
