<?php
/**
 * Summary File Controller
 *
 * Description File Controller
 *
 * ILYA CMS Created by ILYA-IDEA Company.
 * @author Ali Mansoori
 * Date: 7/14/2018
 * Time: 5:15 PM
 * @version 1.0.0
 * @copyright Copyright (c) 2017-2018, ILYA-IDEA Company
 */

namespace Lib\Mvc;

use Lib\Assets\Collection;
use Lib\Assets\Minify\CSS;
use Lib\Authenticates\Auth;
use Lib\Common\MobileDetect;
use Lib\Contents\ContentBuilder;
use Lib\Flash\Session;
use Lib\Mvc\Helper\Locale;
use Lib\RestResponse;
use Lib\Tables\Adapter;
use Lib\Tag;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\Model\Transaction\Manager;
use Phalcon\Registry;

/**
 * @property CSS cssmin
 * @property Helper helper
 * @property Manager $transactions
 * @property Session $flash
 * @property ContentBuilder $content
 * @property Auth $auth
 * @property Tag $tag
 * @property Collection $assetsCollection
 * @property Registry $registry
 * @property MobileDetect $device
 * @property RestResponse $restResponse
 */
class Controller extends \Phalcon\Mvc\Controller
{
    private $fragmentFromGetRequest;
    private $parentIdFromGetRequest;

    public function initialize()
    {
        $this->parentIdFromGetRequest = $this->request->get('parent');
        $this->fragmentFromGetRequest = $this->request->get('fragment');

        if(method_exists($this, 'init'))
            $this->init();

    }

    protected function queryDataTable($data = [], Builder $builder, $columnsSearch = []): Builder
    {
        if ($this->orderQuery($data))
        {
            $builder->orderBy(
                $this->orderQuery($data)
            );
        }

        $searchQuery = $this->searchQuery(
            $data,
            $columnsSearch
        );

        if ($searchQuery)
        {
            $builder->orWhere($searchQuery);
        }

        if (isset($data['length']) && is_numeric($data['length']) && isset($data['start']) && is_numeric($data['start']))
        {
            $start = $data['start'];
            $length = $data['length'];
            if ($length == -1)
            {
                $length = 0;
            }
            $builder->limit($length, $start);
        }

        return $builder;
    }

    private function searchQuery($data = [], $columnsSearch): string
    {
        $condSearch = [];
        if (isset($data['search']) && isset($data['search']['value']) && isset($data['search']['regex']))
        {
            $value = $data['search']['value'];
            $regex = $data['search']['regex'];

            foreach ($columnsSearch as $columnName)
            {
                if ($this->getConditionColumnSearch($value, $regex, $columnName))
                    $condSearch[] = $this->getConditionColumnSearch($value, $regex, $columnName);
            }
        }
        if (isset($data['columns']) && is_array($data['columns']))
        {
            foreach ($data['columns'] as $datum)
            {
                $columnName = $datum['data'];
                $value = $datum['search']['value'];
                $regex = $datum['search']['regex'];

                if ($this->getConditionColumnSearch($value, $regex, $columnName))
                    $condSearch[] = $this->getConditionColumnSearch($value, $regex, $columnName);
            }
        }

        return implode(' OR ', $condSearch);
    }

    private function getConditionColumnSearch($value = '', $regex = 'false', $columnName): ?string
    {
        if ($value)
        {
            $operator = 'LIKE';
            if ($regex == 'true') {
                $operator = 'REGEXP';
                return "REGEXP( $columnName, '$value')";
            }

            return "$columnName $operator '%$value%'";
        }

        return null;
    }

    private function orderQuery($data = []): ?string
    {
        if (!isset($data['columns']) || !isset($data['order']) || !is_array($data['columns']) || !is_array($data['order']))
        {
            return null;
        }

        $orders = [];
        $index = 0;
        foreach ($data['columns'] as $column)
        {
            if ($column['orderable'] == 'true')
            {
                $dataCol = $column['data'];

                foreach ($data['order'] as $order)
                {
                    if ($order['column'] == $index && isset($order['dir']))
                    {
                        $dir = $order['dir'];
                        if ($dir == 'asc' || $dir == 'desc')
                            $orders[] = "$dataCol $dir";
                        break;
                    }
                }
            }
            $index++;
        }

        return implode(',', $orders);
    }
}