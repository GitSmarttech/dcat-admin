<?php

namespace Dcat\Admin\Grid\Filter\Presenter;

use Dcat\Admin\Admin;

class MultipleSelect extends Select
{
    /**
     * Load options for other select when change.
     *
     * @param string $target
     * @param string $resourceUrl
     * @param string $idField
     * @param string $textField
     *
     * @return $this
     */
    public function loadMore($target, $resourceUrl, $idField = 'id', $textField = 'text'): self
    {
        $column = $this->filter->column();

        $script = <<<JS
$(document).on('change', ".{$this->getClass($column)}", function () {
    var target = $(this).closest('form').find(".{$this->getClass($target)}");
    var ids = $(this).find("option:selected").map(function(index,elem) {
            return $(elem).val();
        }).get().join(',');
     
    $.ajax("$resourceUrl?q="+ids).then(function (data) {
        target.find("option").remove();
        $.each(data, function (i, item) {
            $(target).append($('<option>', {
                value: item.$idField,
                text : item.$textField
            }));
        });
        
        $(target).trigger('change');
    });
});
JS;

        Admin::script($script);

        return $this;
    }
}
