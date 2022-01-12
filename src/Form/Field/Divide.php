<?php

namespace Dcat\Admin\Form\Field;

use Dcat\Admin\Form\Field;

class Divide extends Field
{

    public function __construct($label = null)
    {
        $this->label = $label;
    }

    public function render()
    {
        $attributes = '';

        foreach ($this->attributes as $k=>$v){
            $attributes = $attributes.' '.$k.'='.$v.' ';
        }
        if (! $this->label) {
            return '<hr/>';
        }

        return <<<HTML
<div class="mt-2 text-center mb-2 form-divider" $attributes>
  <span class="pos-relative label-close">{$this->label}
  <span class="triangle-icon"></span></span>

</div>
HTML;
    }
}
