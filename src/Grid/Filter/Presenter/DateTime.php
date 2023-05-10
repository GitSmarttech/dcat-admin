<?php

namespace Dcat\Admin\Grid\Filter\Presenter;

use Dcat\Admin\Admin;
use Illuminate\Support\Arr;

class DateTime extends Presenter
{
    public static $js = [
        '@moment',
        '@bootstrap-datetimepicker',
    ];

    public static $css = [
        '@bootstrap-datetimepicker',
    ];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $format = 'YYYY-MM-DD HH:mm:ss';

    /**
     * DateTime constructor.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = $this->getOptions($options);
    }

    /**
     * @param array $options
     *
     * @return mixed
     */
    protected function getOptions(array $options): array
    {
        $options['format'] = Arr::get($options, 'format', $this->format);
        $options['locale'] = Arr::get($options, 'locale', config('app.locale'));

        return $options;
    }

    protected function prepare()
    {
        $script = "$('#{$this->filter->getId()}').datetimepicker(".json_encode($this->options).');';

        Admin::script($script);
    }

    public function variables(): array
    {
        $this->prepare();

        return [
            'group' => $this->filter->group,
        ];
    }
}
