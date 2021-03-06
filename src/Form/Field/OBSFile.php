<?php


namespace Dcat\Admin\Form\Field;


use Dcat\Admin\Form\Field;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Support\JavaScript;

class OBSFile extends Field
{
    protected $view = 'admin::form.obsfile';

    public static $js = [
        '@obsmanager',
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

}
