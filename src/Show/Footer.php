<?php

namespace Dcat\Admin\Show;

use Dcat\Admin\Widgets\Checkbox;
use Illuminate\Contracts\Support\Renderable;

class Footer implements Renderable
{
    /**
     * Footer view.
     *
     * @var string
     */
    protected $view = 'admin::show.footer';

    /**
     * Footer view data.
     *
     * @var array
     */
    protected $data = [];

    /**
     *
     * @var Panel
     */
    protected $panel;

    /**
     * @var string
     */
    protected $resource;

    /**
     * Available buttons.
     *
     * @var array
     */
    protected $buttons = ['reset' => false, 'submit' => false ,'cancel'=>true];

    /**
     * Available checkboxes.
     *
     * @var array
     */
    protected $checkboxes = ['view' => false, 'continue_editing' => false, 'continue_creating' => false];

    /**
     * Default checked.
     *
     * @var arrays
     */
    protected $defaultcheckeds = ['view' => false, 'continue_editing' => false, 'continue_creating' => false];

    /**
     * Footer constructor.
     *
     * @param Panel $panel
     */
    public function __construct(Panel $panel)
    {
        $this->panel = $panel;
    }

    /**
     * Disable reset button.
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disableReset(bool $disable = true)
    {
        $this->buttons['reset'] = ! $disable;

        return $this;
    }

    /**
     * Disable submit button.
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disableSubmit(bool $disable = true)
    {
        $this->buttons['submit'] = ! $disable;

        return $this;
    }

    /**
     * Disable cancel button.
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disableCancel(bool $disable = true)
    {
        $this->buttons['cancel'] = ! $disable;

        return $this;
    }

    /**
     * Disable View Checkbox.
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disableViewCheck(bool $disable = true)
    {
        $this->checkboxes['view'] = ! $disable;

        return $this;
    }

    /**
     * Disable Editing Checkbox.
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disableEditingCheck(bool $disable = true)
    {
        $this->checkboxes['continue_editing'] = ! $disable;

        return $this;
    }

    /**
     * Disable Creating Checkbox.
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disableCreatingCheck(bool $disable = true)
    {
        $this->checkboxes['continue_creating'] = ! $disable;

        return $this;
    }

    /**
     * default View Checked.
     *
     * @param bool $checked
     *
     * @return $this
     */
    public function defaultViewChecked(bool $checked = true)
    {
        $this->defaultcheckeds['view'] = $checked;

        return $this;
    }

    /**
     * default Editing Checked.
     *
     * @param bool $checked
     *
     * @return $this
     */
    public function defaultEditingChecked(bool $checked = true)
    {
        $this->defaultcheckeds['continue_editing'] = $checked;

        return $this;
    }

    /**
     * default Creating Checked.
     *
     * @param bool $checked
     *
     * @return $this
     */
    public function defaultCreatingChecked(bool $checked = true)
    {
        $this->defaultcheckeds['continue_creating'] = $checked;

        return $this;
    }

    /**
     * Get resource path.
     *
     * @return string
     */
    public function resource()
    {
        if (is_null($this->resource)) {
            $this->resource = $this->panel->parent()->resource();
        }

        return $this->resource;
    }

    /**
     * Get request path for resource list.
     *
     * @return string
     */
    protected function getListPath()
    {
        $url = $this->resource();

        return url()->isValidUrl($url) ? $url : '/'.trim($url, '/');
    }

    /**
     * Use custom view.
     *
     * @param string $view
     * @param array $data
     */
    public function view(string $view, array $data = [])
    {
        $this->view = $view;

        $this->data = $data;
    }

    /**
     * Render footer.
     *
     * @return string
     */
    public function render()
    {
        $data = [
            'buttons'    => $this->buttons,
            'width'      => $this->panel->getWidth(),
            'path'       => $this->getListPath(),
        ];

        $data = array_merge($data, $this->data);

        return view($this->view, $data)->render();
    }
}
