<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Common\Format;
use Lib\Exception;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Ad\Models\ModelAdImage;
use Modules\CreateContent\Ad\Models\ModelCategory;
use Modules\System\Native\Models\Language\ModelLanguage;

class GetAdImageController extends ManageController
{
    public function indexAction()
    {
        $response = [];
        $response['title'] = 'Please set title';
        $response['recordsTotal'] = 0;
        $response['recordsFiltered'] = 0;

        try
        {
            $hierarchyId = $this->request->getQuery('hierarchy_id');

            if (!$hierarchyId || !is_numeric($hierarchyId))
            {
                $response['data'] = [];
            }
            else
            {
                $adId = $hierarchyId;

                $data = $this->filterAndValidateData();

                $builder = $this->modelsManager->createBuilder();
                $builder->addFrom(ModelAdImage::class);
                $builder->where("ad_id=:ad_id:", ['ad_id' => $adId]);
                $builder->orderBy('position');
                $response['recordsTotal'] = count($builder->getQuery()->execute()->toArray());

                $builder = $this->queryDataTable(
                    $data,
//                    $this->tableAd->process(false),
                    $builder,
                    [
                        'title',
                    ]
                );

                $row = [];
                /** @var ModelAdImage $adImage */
                foreach ($builder->getQuery()->execute() as $adImage)
                {
                    $row[] = array_merge(
                        $adImage->toArray(),
                        [
                            'DT_RowId' => $adImage->getId(),
                            'user_id' => [
                                'display' => $adImage->getUser()->getUsername(),
                                '_' => $adImage->getId()
                            ],
                            'image_id' => $adImage->getImageId(),
                            'created' => [
                                'display' => $this->convertTimeToDisplay($adImage->getCreated()),
                                '_' => $adImage->getCreated()
                            ],
                            'modified' => [
                                'display' => $this->convertTimeToDisplay($adImage->getModified()),
                                '_' => $adImage->getModified()
                            ]
                        ]
                    );
                }

                $response['recordsFiltered'] = count($row);
                $response['data'] = $row;

                $response = $this->getFiles($response, $adId);
            }
        }
        catch (Exception $exception)
        {
            if ($exception->getCode())
                $this->response->setStatusCode($exception->getCode());

            $response['error'] = $exception->getMessage();
        }

        $this->response->setJsonContent($response);
        $this->response->send();
        die;
    }

    private function filterAndValidateData()
    {
        if (!$this->isValidDraw())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        if (!$this->isValidColumns())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        return $this->request->getQuery();
    }

    private function isValidDraw(): bool
    {
        if ($this->request->getQuery('draw') && is_numeric($this->request->getQuery('draw')))
            return true;

        return false;
    }

    private function isValidColumns(): bool
    {
        if ($this->request->getQuery('columns') && is_array($this->request->getQuery('columns')))
            return true;

        return false;
    }

    private function convertTimeToDisplay(?int $time)
    {
        $created = Format::ilya_when_to_html(
            $time,
            7
        );

        $display = '';
        if (isset($created['data']))
        {
            $display = $created['data'];
            if (isset($created['prefix']) && isset($created['suffix']))
            {
                $display = $created['prefix'] . $created['data']. $created['suffix'];
            }
        }

        return $display;
    }

    private function getFiles(array $response, int $adId)
    {
        /** @var ModelAdImage[] $files */
        $files = ModelAdImage::find([
            'conditions' => 'ad_id=:ad_id:',
            'order' => 'position',
            'bind' => ['ad_id' => $adId]
        ]);


        $response['files']['files'] = [];
        foreach ($files as $file)
        {
            $response['files']['files'][$file->getImageId()] = array_merge(
                $file->toArray(),
                [
                    'web_path' => $this->url->get([
                        'for' => 'show_image__'. ModelLanguage::getCurrentLanguage(),
                        'image_id' => $file->getImageId(),
                        'type' => strtolower(pathinfo(
                            $file->getImage()->getName(),
                            PATHINFO_EXTENSION
                        ))
                    ])
                ]
            );
        }
        return $response;
    }

}