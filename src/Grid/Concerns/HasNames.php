<?php

namespace Dcat\Admin\Grid\Concerns;

use Dcat\Admin\Grid;

/**
 * @method Grid\Model model()
 */
trait HasNames
{
    /**
     * Grid name.
     *
     * @var string
     */
    protected $_name;

    /**
     * HTML element names.
     *
     * @var array
     */
    protected $elementNames = [
        'grid_row'        => 'grid-row',
        'grid_select_all' => 'grid-select-all',
        'grid_per_page'   => 'grid-per-pager',
        'export_selected' => 'export-selected',
    ];

    /**
     * Set name to grid.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->_name = $name;
        $this->tableId = $this->tableId.'-'.$name;

        $model = $this->model();

        $model->setPerPageName("{$name}_{$model->getPerPageName()}")
            ->setPageName("{$name}_{$model->getPageName()}")
            ->setSortName("{$name}_{$model->getSortName()}");

        $this->filter()->setName($name);
        $this->setExporterQueryName();
        $this->setQuickSearchQueryName();

        return $this;
    }

    /**
     * Get name of grid.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getRowName()
    {
        return $this->getElementNameWithPrefix('grid_row');
    }

    /**
     * @return string
     */
    public function getSelectAllName()
    {
        return $this->getElementNameWithPrefix('grid_select_all');
    }

    /**
     * @return string
     */
    public function getPerPageName()
    {
        return $this->getElementNameWithPrefix('grid_per_page');
    }

    /**
     * @return string
     */
    public function getExportSelectedName()
    {
        return $this->getElementNameWithPrefix('export_selected');
    }

    /**
     * @return string
     */
    protected function getElementNameWithPrefix($name)
    {
        $elementName = $this->elementNames[$name];

        if ($this->_name) {
            return sprintf('%s-%s', $this->_name, $elementName);
        }

        return $elementName;
    }
}
