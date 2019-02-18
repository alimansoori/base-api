<?php

namespace Modules\CreateContent\Ad\Controllers;

use Lib\Exception;
use Lib\Messages\Message;
use Lib\Mvc\Controller;
use Lib\Mvc\Model\ModelBlobs;
use Lib\Translate\T;
use Lib\Validation;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Ad\Models\ModelAdDetails;
use Modules\CreateContent\Ad\Models\ModelAdImage;
use Modules\CreateContent\Ad\Models\ModelCategory;
use Modules\CreateContent\Ad\Models\ModelCategoryFields;
use Modules\CreateContent\Ad\Models\ModelFieldOptions;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\Model\Transaction;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Validation\Validator\Callback;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Regex;

class SearchController extends Controller
{
    public function indexAction()
    {
        $response = [];
        try {
            $data = $this->filterAndValidateData();
            $response = $this->validateData($data, $response);

            if (!isset($data['category_id']) || $data['category_id'] == 'null')
                $data['category_id'] = null;

            if (!isset($response['fieldErrors']))
            {
                $columns = [];
                $builder = $this->modelsManager->createBuilder();
                $builder->addFrom(ModelAd::class, 'ad');
                $builder->orderBy('created desc');
                $columns[] = 'ad.id';
                $columns[] = 'ad.title';

                if (!$data['category_id'])
                {
//                    $builder->where('ad.category_id IS NULL');
                }
                else
                {
                    /** @var ModelCategory $categoryInstance */
                    $categoryInstance = ModelCategory::findFirst($data[ 'category_id']);
                    if (!$categoryInstance)
                    {
                        $builder->where('ad.category_id=:cat_id:', [
                            'cat_id' => $data['category_id']
                        ]);
                    }
                    else
                    {
                        $childsCat = array_merge(
                            [$data['category_id']],
                            $categoryInstance->getChildList()
                        );

                        if (!empty($childsCat))
                        {
                            $builder->where('ad.category_id IN ({ids:array})', [
                                'ids' => $childsCat
                            ]);
                        }
                        else
                        {
                            $builder->where('ad.category_id=:cat_id:', [
                                'cat_id' => $data['category_id']
                            ]);
                        }
                    }
                }

                $modelImages = ModelAdImage::class;
                $columns[] = "(SELECT b.image_id FROM {$modelImages} AS b WHERE b.ad_id=ad.id ORDER BY b.position LIMIT 0,1) AS image";

                $columns = $this->buildColumns($builder, $columns, $data['category_id']);

                $builder->columns($columns);
                $result = $builder->getQuery()->execute()->toArray();

                if (!$this->hasDataSearch($data))
                {
                    $newData = [];

                    /** @var ModelCategory $category */
                    $category = ModelCategory::findFirst($data['category_id']);

                    if ($category)
                    {
                        foreach ($category->getFieldsDefSearch() as $catFieldId => $field)
                        {
                            if (isset($field['def']) && isset($field['type']))
                            {
                                if ($field['type'] == 'price')
                                {
                                    if ($field['def'] == -3){
                                        $newData[$catFieldId] = '|';
                                    }
                                    else
                                        $newData[$catFieldId] = $field['def'];
                                }
                                else
                                {
                                    $newData[$catFieldId] = $field['def'];
                                }
                            }
                        }
                    }

                    $data = $data + $newData;
                }

                $result = $this->search($result, $data);

//                $length = 1;
//                $final = array_slice($result, 0, 1);
                $response['pageNumber'] = 1;
                if (isset($data[ 'page' ]) && is_numeric($data[ 'page' ])) {
//                    $final = array_slice($result, $data[ 'page' ] * $length, $length);
                    $response['pageNumber'] = $data['page'];
                }

                $response['pageSize'] = 2;
                $response['totalNumber'] = round(count($result)/$response['pageSize']);
                $response['data'] = $result;
            }
        }
        catch (Failed $exception) {
            $this->response->setStatusCode(406);

            if ($exception->getRecord()) {
                foreach ($exception->getRecord()->getMessages() as $message) {
                        $response[ 'fieldErrors' ][] = [
                            'name'   => $message->getField(),
                            'status' => $message->getMessage()
                        ];
                }
            } else {
                $response[ 'error' ] = $exception->getMessage();
            }
        }
        catch (Exception $exception) {
            if ($exception->getCode()) {
                $this->response->setStatusCode($exception->getCode());
            }

            $response[ 'error' ] = $exception->getMessage();
        }

        $this->response->setJsonContent($response);
        $this->response->send();
        die;
    }

    private function filterAndValidateData()
    {
        if (!$this->isValidAction()) {
            throw new Exception(T::_('access_denied'), 400);
        }

        if (!$this->isValidData()) {
            throw new Exception(T::_('access_denied'), 400);
        }

        $data = $this->request->getQuery('data');

        if (!is_array(reset($data))) {
            throw new Exception(T::_('access_denied'), 400);
        }

        $data = reset($data);

        if (!isset($data['category_id']) || !$data['category_id'] || !is_numeric($data['category_id']))
        {
            foreach ($data as $key=>$val)
            {
                if (is_numeric($key))
                    unset($data[$key]);
            }
        }
        else
        {
            /** @var ModelCategory $category */
            $category = ModelCategory::findFirst($data[ 'category_id']);

            if (!$category)
                throw new Exception(T::_('access_denied'), 400);

            $fields = array_keys($category->getFieldsEditor());

            foreach ($data as $key=>$val)
            {
                if (is_numeric($key) && !in_array($key, $fields))
                {
                    unset($data[$key]);
                }
            }
        }

        return $data;
    }

    private function isValidAction(): bool
    {
        if ($this->request->getQuery('action') == 'create') {
            return true;
        }

        return false;
    }

    private function isValidData(): bool
    {
        if ($this->request->getQuery('data') && is_iterable($this->request->getQuery('data'))) {
            return true;
        }

        return false;
    }

    private function validateData(array $data, $response=[])
    {
        $validation = new Validation();

        foreach ($data as $field=>$value)
        {
            if ($value == 'null')
            {
                $value = null;
                $data[$field] = null;
            }
            if ($field == 'category_id')
            {
                $validation->add(
                    'category_id',
                    new Numericality([
                        'allowEmpty' => true
                    ])
                );
                continue;
            }

            if (is_numeric($field))
            {
                /** @var ModelCategoryFields $fieldModel */
                $fieldModel = ModelCategoryFields::findFirst($field);

                if ($fieldModel)
                {
                    if( strpos( $value, '|' ) !== false) {
                        $validation->add(
                            "$field",
                            new Callback([
                                'callback' => function($data) use($field, $fieldModel, $validation){
                                    $value = explode('|', $data[$field]);
                                    $from = $value[0];
                                    $to = $value[1];
                                    if ($from == 'null') $from = null;
                                    if ($to == 'null') $to = null;
                                    if (!preg_match("/{$fieldModel->getField()->getValidationPatternSearch()}/", $from))
                                    {
                                        return false;
                                    }
                                    if (!preg_match("/{$fieldModel->getField()->getValidationPatternSearch()}/", $to))
                                    {
                                        return false;
                                    }
                                    return true;
                                },
                                'message' => $fieldModel->getField()->getErrorMessage(),
                                'allowEmpty' => false
                            ])
                        );
                    }
                    else
                    {
                        $validation->add(
                            "$field",
                            new Regex([
                                'pattern' => '/'. $fieldModel->getField()->getValidationPatternSearch(). '/',
                                'message' => $fieldModel->getField()->getErrorMessage(),
                                'allowEmpty' => true
                            ])
                        );
                    }
                }
            }
        }

        /** @var Message $message */
        foreach ($validation->validate($data) as $message)
        {
            $response['fieldErrors'][] = [
                'name' => $message->getField(),
                'status' => $message->getMessage()
            ];
        }
        return $response;
    }

    private function buildColumns(Builder $builder, $columns = [], $categoryId)
    {
        $modelDetails = ModelAdDetails::class;
        /** @var ModelCategory $categoryFields */
        $categoryFields = ModelCategory::findFirst($categoryId);

        foreach (array_keys($categoryFields->getFieldsEditor()) as $field)
        {
            $columns[] = "(SELECT b{$field}.value FROM {$modelDetails} AS b{$field} WHERE b{$field}.ad_id=ad.id AND b{$field}.category_field_id={$field} ORDER BY b{$field}.value LIMIT 0,1) AS v{$field}";
        }

        return $columns;
    }

    private function search(array $result, array $data)
    {
        $res = $result;
        $res = $this->filterImages($res, $data);
        foreach ($data as $catFieldId => $value) {
            if (!is_numeric($catFieldId)) {
                continue;
            }

            /** @var ModelCategory $category */
            $category = ModelCategory::findFirst($data['category_id']);

            if (!$category)
                continue;


            /** @var ModelCategoryFields $catField */
            $catField = $category->getCategoryFields([
                'conditions' => 'id=:id:',
                'bind' => ['id' => $catFieldId]
            ])->getFirst();

            if (!$catField)
                continue;

            $value = $this->valueRange($value);

            if ($catField->getField()->getTypeName() == 'price')
            {
                /** @var ModelFieldOptions[] $options */
                $options = $catField->getField()->getOptions();

                $row = [];
                foreach ($res as $ad)
                {
                    if (!isset($ad['v'.$catFieldId]))
                        continue;

                    $ad['v'.$catFieldId. '_label'] = $ad['v'.$catFieldId] . ' تومان';
                    foreach ($options as $option)
                    {
                        if ($ad['v'.$catFieldId] == $option->getValue())
                        {
                            $ad['v'.$catFieldId. '_label'] = $option->getLabel();
                            break;
                        }
                    }

                    if (is_array($value)) // is range
                    {
                        if (is_numeric($value['from']) && is_numeric($value['to']))
                        {
                            if ($value['from'] <= $ad['v'. $catFieldId] && $value['to'] >= $ad['v'. $catFieldId])
                                $row[] = $ad;
                        }
                        elseif (is_numeric($value['from']))
                        {
                            if ($value['from'] <= $ad['v'. $catFieldId])
                                $row[] = $ad;
                        }
                        elseif (is_numeric($value['to']))
                        {
                            if ($value['to'] >= $ad['v'. $catFieldId])
                                $row[] = $ad;
                        }
                        else
                        {
                            $row[] = $ad; // harchi
                        }
                    }
                    else
                    {
                        if ($ad['v'.$catFieldId] == $value)
                        {
                            $row[] = $ad;
                        }
                    }

                }

                $res = $row;
                continue;
            }

            if ($catField->getField()->getTypeName() == 'select_range')
            {
                /** @var ModelFieldOptions[] $options */
                $options = $catField->getField()->getOptions();

                $row = [];
                foreach ($res as $ad)
                {
                    if (!isset($ad['v'.$catFieldId]))
                        continue;

                    $ad['v'.$catFieldId. '_label'] = $ad['v'.$catFieldId];
                    foreach ($options as $option)
                    {
                        if ($ad['v'.$catFieldId] == $option->getValue())
                        {
                            $ad['v'.$catFieldId. '_label'] = $option->getLabel();
                            break;
                        }
                    }

                    if (is_array($value)) // is range
                    {
                        if (is_numeric($value['from']) && is_numeric($value['to']))
                        {
                            if ($value['from'] <= $ad['v'. $catFieldId] && $value['to'] >= $ad['v'. $catFieldId])
                                $row[] = $ad;
                        }
                        elseif (is_numeric($value['from']))
                        {
                            if ($value['from'] <= $ad['v'. $catFieldId])
                                $row[] = $ad;
                        }
                        elseif (is_numeric($value['to']))
                        {
                            if ($value['to'] >= $ad['v'. $catFieldId])
                                $row[] = $ad;
                        }
                        else
                        {
                            $row[] = $ad; // harchi
                        }
                    }
                    else
                    {
                        $row[] = $ad;
                    }
                }

                $res = $row;

                continue;
            }

            if ($catField->getField()->getTypeName() == 'radio')
            {
                /** @var ModelFieldOptions[] $options */
                $options = $catField->getField()->getOptions();

                $row = [];
                foreach ($res as $ad)
                {
                    if (!isset($ad['v'.$catFieldId]))
                        continue;

                    foreach ($options as $option)
                    {
                        if ($ad['v'.$catFieldId] == $option->getValue())
                        {
                            $ad['v'.$catFieldId. '_label'] = $option->getLabel();
                            break;
                        }
                    }

                    if ($value == -100)
                    {
                        $row[] = $ad;
                    }
                    elseif ($ad['v'.$catFieldId] == $value)
                    {
                        $row[] = $ad;
                    }
                }

                $res = $row;
                continue;
            }

            if ($catField->getField()->getTypeName() == 'select' || $catField->getField()->getTypeName() == 'select2')
            {
                /** @var ModelFieldOptions[] $options */
                $options = $catField->getField()->getOptions();

                $row = [];
                foreach ($res as $ad)
                {
                    if (!isset($ad['v'.$catFieldId]))
                        continue;

                    foreach ($options as $option)
                    {
                        if ($ad['v'.$catFieldId] == $option->getValue())
                        {
                            $ad['v'.$catFieldId. '_label'] = $option->getLabel();
                            break;
                        }
                    }

                    if (!$value || $value == -100)
                    {
                        $row[] = $ad;
                    }
                    elseif ($ad['v'.$catFieldId] == $value)
                    {
                        $row[] = $ad;
                    }
                }

                $res = $row;
                continue;
            }
        }

        return $res;
    }

    private function filterImages($result, $data)
    {
        if (!isset($data['image']) || $data['image'] != 1)
            return $result;

        $res = [];

        foreach ($result as $ad)
        {
            if (is_numeric($ad['image']))
                $res[] = $ad;
        }

        return $res;
    }

    private function valueRange($value)
    {
        if( strpos( $value, '|' ) !== false)
        {
            $valueNew = explode('|', $value);
            $from = $valueNew[ 0 ];
            $to = $valueNew[ 1 ];
            if ($from == 'null') {
                $from = null;
            }
            if ($to == 'null') {
                $to = null;
            }

            if (is_numeric($from) && is_numeric($to) && $from > $to)
            {
                return [
                    'from' => $to,
                    'to' => $from
                ];
            }

            return [
                'from' => $from,
                'to' => $to
            ];
        }

        return $value;
    }

    private function hasDataSearch($data)
    {
        $categoryId = $data['category_id'];

        $i = 0;
        foreach ($data as $catFieldId => $value)
        {
            if (!is_numeric($catFieldId)) {
                continue;
            }

            /** @var ModelCategory $category */
            $category = ModelCategory::findFirst($categoryId);

            if (!$category)
                continue;


            /** @var ModelCategoryFields $catField */
            $catField = $category->getCategoryFields([
                'conditions' => 'id=:id:',
                'bind' => ['id' => $catFieldId]
            ])->getFirst();

            if (!$catField)
                continue;

            $i++;
        }

        if ($i)
            return true;

        return false;
    }
}