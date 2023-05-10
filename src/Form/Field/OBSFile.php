<?php


namespace Dcat\Admin\Form\Field;


use Dcat\Admin\Form\Field;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Support\JavaScript;

class OBSFile extends Field
{
    protected $view = 'admin::form.obsfile';

    public static $css = [
        '@obs'
    ];

    public static $js = [
        '@obs',
    ];

    public function __construct($column, $arguments = [])
    {
        $this->addVariables(
            [
                'uniqueId' => $this->uuid(),
            ]
        );
        parent::__construct($column, $arguments);
    }

    public function render()
    {
        $this->addScript();
        return parent::render();
    }

    public function uuid($pre = null)
    {
        $chars = array(
            0,
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'q',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z'
        );
        $rand = $chars[mt_rand(0, 35)] . $chars[mt_rand(0, 35)] . $chars[mt_rand(0, 35)] . $chars[mt_rand(0, 35)];
        return substr(hash('sha256', microtime()), 0, 8) . $pre . $rand . uniqid();
    }

    protected function addScript()
    {
        $id = $this->getElementId();
        $formId = $this->getFormElementId();
        $value = $this->value;
        $name = $this->getElementName();
        $uniqueId = $this->uuid();
        $OBS_KEY = env('OBS_KEY');
        $OBS_ACCESS = env('OBS_ACCESS');
        $OBS_SERVER = env('OBS_SERVER');
        $OBS_BUCKET = env('OBS_BUCKET');
        $OBS_CDN = env('OBS_CDN');
        $this->script = <<<JS
(function () {
    let box = window.$("#obs-{$id}");
    let input = window.$("#$id");
    let cForm = '#$formId';
    let value = "$value";
    
    if (value) {
        // 隐藏上传文件的按钮
        box.find('.obs-file input,.obs-file .obs-file-label').hide();
        // 显示文件列表容器
        box.find('.file-list').show();
        // 添加文件名到文件列表
        let file_item = makeFileRow(value);
        box.find('.file-list').append(file_item);
        // 添加文件表单
        let file_input = '<input name="$name" class="file-input" type="hidden" value="' + value + '">';
        box.find('.obs-file-hidden-input').append(file_input);
    }
    
    function makeFileRow (value='error') {
        let html = '<li><p class="title">'+value+'</p><span class="file-action"><i class="feather icon-x red-dark"></i></span></li>';
        return html;
    }
    
    function cleanFile () {
        // 删除文件列表
        box.find('.file-list').empty();
        // 显示上传按钮
        box.find('.obs-file input,.obs-file .obs-file-label').show();
        // 隐藏文件列表容器
        box.find('.file-list').hide();
        // 清空文件
        let obj = box.find('input[type="file"]');
        obj[0].value = '';
        // 清空文件表单
        let input_value = box.find('input[name="$name"]');
        if(input_value.length > 0){
          input_value[0].value = '';
        }
    }
  
    function getOBSClient () {
        return new ObsClient({
          access_key_id: "$OBS_KEY", // 配置AK
          secret_access_key: "$OBS_ACCESS", // 配置SK
          server: "$OBS_SERVER", // 配置服务地址
          timeout: 300,
          useRawXhr: true
        });
    }

  // 上传文件
  input.on('change', function () {
    // 获取当前文件
    let file = input[0].files[0];

    // 获取文件大小
    let file_size = file.size;
    // 如果文件大于1G，不允许上传
    if (false || file_size > 1073741824) {
      Dcat.error('文件大小超出最大限制');
      return false;
    }

    // 获取随机文件名
    let rand_name = "$uniqueId";
    let arr = file.name.split('.');
    let ext = arr.pop();
    rand_name = rand_name + '.' + ext;
    let file_url;
    let obsClient = getOBSClient();

    // 打开蒙版
    let loading = layer.open({
      type: 3,
      icon: 1,
      shade: [0.8, '#393D49']
    });

    // 上传文件
    obsClient.putObject({
      Bucket: "$OBS_BUCKET",
      Key: rand_name,
      SourceFile: file,
    }, function (err, result) {
      layer.close(loading);
      if (err) {
        // 上传失败
        cleanFile();
        Dcat.error('文件上傳失敗，請稍後重試或聯繫管理員');
        return false;
      }else {
        file_url = "$OBS_CDN" + '/' + rand_name;

        // 隐藏上传文件的按钮
        box.find('.obs-file input,.obs-file .obs-file-label').hide();
        // 显示文件列表容器
        box.find('.file-list').show();
        // 添加文件名到文件列表
        let file_item = makeFileRow(file_url);
        box.find('.file-list').append(file_item);

        // 将文件url添加到表单中
        let file_input = '<input name="$name" class="file-input" type="hidden" value="' + file_url + '">';
        box.find('.obs-file-hidden-input').append(file_input);
      }
    })
  });
    
    // 如果触发删除
    window.$('body').on('click','#obs-{$id} .file-action', function () {
      cleanFile();
    });
  
})();
JS;

    }

}
