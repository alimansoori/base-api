<?php
namespace Modules\System\PageManager\Models\WidgetInstance;

use Modules\System\Widgets\Models\ModelWidgetViewDesktop;
use Modules\System\Widgets\Models\ModelWidgetViewMobile;
use Modules\System\Widgets\Models\ModelWidgetViewTablet;

trait TModelPageWidgetMapEvents
{
    public function afterCreate()
    {
        $this->createView(new ModelWidgetViewDesktop());
        $this->createView(new ModelWidgetViewMobile());
        $this->createView(new ModelWidgetViewTablet());
    }

    private function createView($model)
    {
        if($this->getTransaction())
            $model->setTransaction($this->getTransaction());

        $model->setWidgetId($this->getId());

        if(!$model->create())
        {
            if($model->getTransaction())
                $model->getTransaction()->rollback('Widget view was not made after createWidget');

            foreach($model->getMessages() as $message)
                $this->appendMessage($message);
        }
    }

}