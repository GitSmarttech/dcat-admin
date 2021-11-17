<?php

namespace Dcat\Admin\Form\Field;

use Dcat\Admin\Form\Field;
use Dcat\Admin\Support\Helper;
use Illuminate\Database\Eloquent\Model;

class MultipleText extends Field
{
    protected $view = 'admin::form.multipletext';


    /**
     * Set options.
     *
     * @param array|\Closure|string $options
     *
     * @return $this|mixed
     */
    public function options($options = [])
    {
        if ($options instanceof \Closure) {
            $this->options = $options;

            return $this;
        }

        // remote options
        if (is_string($options)) {
            // reload selected
            if (class_exists($options) && in_array(Model::class, class_parents($options))) {
                return $this->model(...func_get_args());
            }

            return $this->loadRemoteOptions(...func_get_args());
        }

        $this->options = Helper::array($options);

        return $this;
    }

    public function render()
    {
        $this->addVariables(
            [
                'options' => $this->options,
            ]
        );
        return parent::render();
    }
}
