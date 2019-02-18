<?php
namespace Modules\System\PageManager\Models\PageDesign;


use Lib\Mvc\Model;

class ModelPageDesign extends Model
{
    use TModelPageDesignProperties;
    use TModelPageDesignValidation;
    use TModelPageDesignEvents;
    use TModelPageDesignRelations;

    protected function init()
    {
        $this->setSource('page_design');
        $this->setDbRef(true);
    }
}