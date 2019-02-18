<?php
namespace Modules\System\Widgets\DTE\Table;


use Lib\DTE\Table;
use Lib\DTE\Table\Buttons\Editor\ButtonCreate;
use Lib\DTE\Table\Buttons\Editor\ButtonEdit;
use Lib\DTE\Table\Buttons\Editor\ButtonRemove;
use Lib\Mvc\Model\Widgets\ModelWidgets;
use Lib\Translate\T;
use Modules\System\Widgets\DTE\Table\Widgets\TColumns;

class TableWidgets extends Table
{
    use TColumns;

    public function init()
    {
        $this->setDom("Bflrtip");
        $this->rowGroup->setDataSrc('place_name');
    }

    /**
     * Summary Function initData
     *
     * Output an array of
     * <code>
     * {
     *  'DT_RowId': 'row_1',
     *  'id': '1',
     *  'name': 'widget 1',
     *  'namespace': 'Modules\Users\Session\Widgets\Calender',
     *  'place': 'header',
     *  'place_name': 'Footer',
     *  'position':'3',
     *  'rout_name': 'home__fa',
     *  'width': '2fr',
     *  'created': '2019-02-25 13:10:25',
     *  'modified': '2019-02-25 13:10:25'
     * }
     * </code>
     *
     */
    public function initData()
    {
        if(!$this->request->getPost('id_from_parent') && !is_numeric($this->request->getPost('id_from_parent')))
        {
            $this->data = [];
            return;
        }

        $params = [];
        $routeName   = $this->request->getPost('id_from_parent');
//        $routeName = $this->router->getRouteBy($routeName)->getName();

        $params['conditions'] = 'route_name=:route_name:';
        $params['bind']['route_name'] = $routeName;
        $params['order'] = 'place, position';

        $result = [];
        $widgets = ModelWidgets::find($params);

        /** @var ModelWidgets $widget */
        foreach($widgets as $widget)
        {
            $row = [];
            $row['DT_RowId'] = 'row_'. $widget->getId();
            $row['place_name'] = T::_($widget->getPlaceWidget()->getName());

            $result[] = array_merge($widget->toArray(), $row);
        }

        $this->data = $result;
    }

    public function initColumns()
    {
        $this->columnName();
        $this->columnNamespace();
//        $this->columnPlacement();
        $this->columnDisplay();
        $this->columnPosition();
        $this->columnWidth();
    }

    public function initButtons()
    {
        $create = new ButtonCreate();
        $this->addButton($create);

        $edit = new ButtonEdit();
        $this->addButton($edit);

        $remove = new ButtonRemove();
        $this->addButton($remove);
    }

    public function initAjax()
    {
    }
}