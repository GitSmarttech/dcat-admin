<style>
    .webuploader-pick {
        background-color: @primary;
    }

    .obs-uploader .placeholder .flashTip a {
        color: @primary(-10);
    }

    .obs-uploader .statusBar .upload-progress span.percentage,
    .obs-uploader .filelist li p.upload-progress span {
        background: @primary(-8);
    }

    .obs-uploader .placeholder {
        border: 3px dashed #e6e6e6;
        text-align: center;
        color: #ccc;
        font-size: 16px;
        position: relative;
    }

    .obs-uploader .placeholder:before {
        font-family: feather;
        font-size: 58px;
        content: "\E8E3";
    }

    .obs-file {
        display: inline-block;
        margin-bottom: 0;
    }

    .obs-file, .obs-file-input {
        position: relative;
        width: 100%;
        /*height: calc(1.25em + 1.4rem + 1px);*/
        height: auto;
    }

    .obs-file-input {
        z-index: 2;
        margin: 0;
        opacity: 0;
    }

    .obs-file-label {
        left: 0;
        z-index: 1;
        height: calc(1.25em + 1.4rem + 1px);
        font-weight: 400;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: 5px;
        padding: .4rem .7rem;
    }

    .obs-file-label, .obs-file-label:after {
        position: absolute;
        top: 0;
        right: 0;
        line-height: 1.5rem;
        color: #4e5154;
    }

    .obs-file .file-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: none;
    }

    .obs-file .file-list li {
        list-style-type: none;
        width: 100%;
        height: 38px;
        background: #fff;
        box-shadow: 0 3px 1px -2px rgb(0 0 0 / 5%), 0 2px 2px 0 rgb(0 0 0 / 5%), 0 1px 5px 1px rgb(0 0 0 / 5%);
        margin: 0 8px 10px 0;
        border-radius: .25rem;
        border: 0;
        padding: 0;
        text-align: center;
        position: relative;
        float: left;
        overflow: hidden;
        font-size: 12px;
        display: table;
        vertical-align: middle;
    }

    .obs-file .file-list p.title {
        display: block;
        font-weight: 600;
        font-size: 1rem;
        vertical-align: middle;
        height: 38px;
        line-height: 30px;
        padding-left: 8px;
        float: left;
        text-align: left;
        max-width: 100%;

        left: 0;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        top: 35px;
        text-indent: 5px;
        width: 100%;
        padding-top: 4px;
        color: #555;
        margin: 3px auto;
    }

    .obs-file .file-list li .file-action {
        float: right;
        margin: 12px 10px 0;
        cursor: pointer;
        position: absolute;
        right: 0;
        font-size: 13px;
    }

    .obs-progress {
        display: none;
    }

    .obs-file-hidden-input {
        display: none;
    }
</style>
<div class="{{$viewClass['form-group']}} {{ $class }}">
    <label for="{{$column}}" class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        <div class="obs-file">
            <input type="file" class="obs-file-input" id="{{$class}}">
            <label class="obs-file-label" for="{{$class}}">????????????</label>
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
<script src="vendor/dcat-admin/dcat/plugins/obs/esdk-obs-browserjs-3.19.5.min.js"></script>
<script require="@obsmanager" init="{!! $selector !!}">
  let input = $this.find('input');
  let cForm = '#{{$formId}}';

  let value = "{{$value}}";
  if (value) {
    // ???????????????????????????
    $this.find('.obs-file input,.obs-file .obs-file-label').hide();
    // ????????????????????????
    $this.find('.file-list').show();
    // ??????????????????????????????
    let file_item = makeFileRow(value);
    $this.find('.file-list').append(file_item);
    // ??????????????????
    let file_input = '<input name="{{$name}}" class="file-input" type="hidden" value="' + value + '">';
    $this.find('.obs-file-hidden-input').append(file_input);
  }

  function makeFileRow (name = '??????') {
    let html = '                <li>\n' +
      '                    <p class="title">' + name + '</p>\n' +
      '                    <span class="file-action">\n' +
      '                        <i class="feather icon-x red-dark"></i>\n' +
      '                    </span>\n' +
      '                </li>';
    return html;
  }

  function cleanFile () {
    // ??????????????????
    $this.find('.file-list').empty();
    // ??????????????????
    $this.find('.obs-file input,.obs-file .obs-file-label').show();
    // ????????????????????????
    $this.find('.file-list').hide();
    // ????????????
    let obj = $this.find('input[type="file"]');
    obj[0].value = '';
    // ??????????????????
    $this.find('input[name="{{$name}}"]')[0].value = '';
  }

  // ??????????????????
  $('body').on('click','{{$selector}} .file-action', function () {
    cleanFile();
  });

  // ????????????
  input.on('change', function () {
    // ??????????????????
    let file = input[0].files[0];

    // ??????????????????
    let file_size = file.size;
    // ??????????????????1G??????????????????
    if (false || file_size > 1073741824) {
      Dcat.error('??????????????????????????????');
      return false;
    }


    // ?????????????????????
    let rand_name = "{{$uniqueId}}";
    let arr = file.name.split('.');
    let ext = arr[1];
    rand_name = rand_name + '.' + ext;

    let file_url;
    let obsClient = getOBSClient();

    // ????????????
    let loading = layer.open({
      type: 3,
      icon: 1,
      shade: [0.8, '#393D49']
    });

    // ????????????
    obsClient.putObject({
      Bucket: "{{env('OBS_BUCKET')}}",
      Key: rand_name,
      SourceFile: file,
    }, function (err, result) {
      layer.close(loading);
      if (err) {
        // ????????????
        cleanFile();
        Dcat.error('??????????????????????????????????????????????????????');
        return false;
      }else {
        file_url = "{{env('OBS_CDN')}}/" + rand_name;

        // ???????????????????????????
        $this.find('.obs-file input,.obs-file .obs-file-label').hide();
        // ????????????????????????
        $this.find('.file-list').show();
        // ??????????????????????????????
        let file_item = makeFileRow(file_url);
        $this.find('.file-list').append(file_item);

        // ?????????url??????????????????
        let file_input = '<input name="{{$name}}" class="file-input" type="hidden" value="' + file_url + '">';
        $this.find('.obs-file-hidden-input').append(file_input);
      }
    })


  });

  function getOBSClient () {
    return new ObsClient({
      access_key_id: "{{env('OBS_KEY')}}", // ??????AK
      secret_access_key: "{{env('OBS_ACCESS')}}", // ??????SK
      server: "{{env('OBS_SERVER')}}", // ??????????????????
      timeout: 300,
      useRawXhr: true
    });
  }



  var OBSProgressCallback = function (transferredAmount, totalAmount, totalSeconds) {
    console.log('????????????');
    // ???????????????????????????KB/S???
    let speed = transferredAmount * 1.0 / totalSeconds / 1024;
    console.log(speed + 'KB/S');
    // ???????????????????????????
    let percent = transferredAmount * 100.0 / totalAmount;
    console.log(percent + '%');
  };

</script>

