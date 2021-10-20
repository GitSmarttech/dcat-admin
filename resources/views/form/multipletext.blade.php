<style>
    .div-box {
        border: 1px solid #586cb1;
        min-height: 34px;
        height: auto;
        display: flex;
        padding: 0 26px 0 10px;
    }

    .input-box {
        border: none;
        outline: none;
    }

    .ul-span {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .ul-item {
        padding: 2px 5px;
        background-color: #586cb1;
        color: white;
        margin-right: 5px;
    }
</style>
<div class="{{$viewClass['form-group']}} {{ $class }}">
    <label for="{{$column}}" class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        <div class="div-box">
            <div class="ul-span">

                @foreach($options as $select => $option)
                    <span class="ul-item">
                        {{$option}}
                        <input name='{{$name}}[]' value='{{$option}}' style = 'display:none'>
                        <span class="del-span">×</span>
                    </span>
                @endforeach
            </div>
            <span class="del-ul">×</span>
            <input type="text" class="input-box">
        </div>
        @include('admin::form.help-block')
    </div>
</div>

<script>
    $(document).ready(function () {
        let name = "{{$name}}";
        $(".div-box").click(function () {
            $(".input-box").eq(0).focus()
        })
        $(".input-box").eq(0).blur(function () {
            if ($(this).val() != '') {
                let html = "<span class='ul-item'>" + $(this).val() + "<input name='"+name+"[]' value='" + $(this).val() + "' style = 'display:none'><span class='del-span'>×</span></span>"
                $(".ul-span").eq(0).append(html);
                $(this).val("")
            }
        });

        // $('.input-box').keyup(function(event){
        $(document).keydown(function(event){
            if(event.keyCode ==13){
                event.preventDefault();
                return false;
            }
        });
        $(document).keyup(function(event){
            if(event.keyCode ==13){
                $('form').each(function() {
                    event.preventDefault();
                });
                let self= $(".input-box").eq(0)
                if ($(self).val() != '') {
                    let html = "<span class='ul-item'>" + $(self).val() + "<input name='"+name+"[]' value='" + $(self).val() + "' style = 'display:none'><span class='del-span'>×</span></span>"
                    $(".ul-span").eq(0).append(html);
                    $(self).val("")
                }
            }
        });
        $(".del-ul").click(function () {
            $(".ul-item").each(function(){
                $(this).remove();
            })
        })
        $(".ul-span").on('click','.del-span',function(e){
            console.log(1,$(this))
            let item=$(this).parent(".ul-item");
            $(item).remove();
        })
    })


</script>

