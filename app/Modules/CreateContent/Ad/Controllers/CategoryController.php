<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Common\Arrays;
use Lib\Mvc\Controller;
use Lib\Mvc\Controllers\AdminController;
use Modules\CreateContent\Ad\Models\ModelCategory;

class CategoryController extends AdminController
{
    public function categoryForSelect2Action()
    {
        $this->response->setJsonContent([
            'id' => null,
            'title' => 'همه آگهی ها',
            'parent_id' => null,
            'parent_title' => null,
            'count_child' => 3,
            'children' => [
                [
                    'id' => 1,
                    'title' => 'املاک',
                    'parent_id' => null,
                    'parent_title' => null,
                    'count_child' => 4,
                ],
                [
                    'id' => 2,
                    'title' => 'وسایل نقلیه',
                    'parent_id' => null,
                    'parent_title' => null,
                    'count_child' => 2,
                ]
            ]
        ]);

        if ($this->request->getQuery('category') == 1) // املاک
        {
            $this->response->setJsonContent([
                'id' => 1,
                'title' => 'املاک',
                'parent_id' => null,
                'parent_title' => null,
                'count_child' => 4,
                'children' => [
                    [
                        'id' => 3,
                        'title' => 'فروش مسکونی',
                        'parent_id' => 1,
                        'parent_title' => 'املاک',
                        'count_child' => 3,
                    ],
                    [
                        'id' => 4,
                        'title' => 'اجاره مسکونی',
                        'parent_id' => 1,
                        'parent_title' => 'املاک',
                        'count_child' => 2,
                    ],
//                    [
//                        'id' => 5,
//                        'title' => 'فروش اداری',
//                        'parent_id' => 1,
//                        'parent_title' => 'املاک',
//                        'count_child' => 1,
//                    ],
//                    [
//                        'id' => 6,
//                        'title' => 'اجاره اداری',
//                        'parent_id' => 1,
//                        'parent_title' => 'املاک',
//                        'count_child' => 1,
//                    ]
                ]
            ]);
        }

        if ($this->request->getQuery('category') == 3) // فروش مسکونی
        {
            $this->response->setJsonContent([
                'id' => 3,
                'title' => 'فروش مسکونی',
                'parent_id' => 1,
                'parent_title' => 'املاک',
                'count_child' => 4,
                'children' => [
                    [
                        'id' => 9,
                        'title' => 'آپارتمان',
                        'parent_id' => 3,
                        'parent_title' => 'فروش مسکونی',
                        'count_child' => 0,
                    ],
                    [
                        'id' => 10,
                        'title' => 'خانه و ویلا',
                        'parent_id' => 3,
                        'parent_title' => 'فروش مسکونی',
                        'count_child' => 0,
                    ],
                    [
                        'id' => 11,
                        'title' => 'زمین و کلنگی',
                        'parent_id' => 3,
                        'parent_title' => 'فروش مسکونی',
                        'count_child' => 0,
                    ]
                ]
            ]);
        }

        if ($this->request->getQuery('category') == 4) // اجاره مسکونی
        {
            $this->response->setJsonContent([
                'id' => 4,
                'title' => 'اجاره مسکونی',
                'parent_id' => 1,
                'parent_title' => 'املاک',
                'count_child' => 2,
                'children' => [
                    [
                        'id' => 16,
                        'title' => 'آپارتمان',
                        'parent_id' => 4,
                        'parent_title' => 'اجاره مسکونی',
                        'count_child' => 0,
                    ],
                    [
                        'id' => 17,
                        'title' => 'خانه و ویلا',
                        'parent_id' => 4,
                        'parent_title' => 'اجاره مسکونی',
                        'count_child' => 0,
                    ]
                ]
            ]);
        }

        if ($this->request->getQuery('category') == 9) // آپارتمان
        {
            $this->response->setJsonContent([
                'id' => 9,
                'title' => 'آپارتمان',
                'parent_id' => 3,
                'parent_title' => 'فروش مسکونی',
                'count_child' => 0,
                'children' => [],
            ]);
        }

        if ($this->request->getQuery('category') == 10) // خانه و ویلا
        {
            $this->response->setJsonContent([
                'id' => 10,
                'title' => 'خانه و ویلا',
                'parent_id' => 3,
                'parent_title' => 'فروش مسکونی',
                'count_child' => 0,
                'children' => [],
            ]);
        }

        if ($this->request->getQuery('category') == 16) // آپارتمان
        {
            $this->response->setJsonContent([
                'id' => 6,
                'title' => 'آپارتمان',
                'parent_id' => 4,
                'parent_title' => 'اجاره مسکونی',
                'count_child' => 0,
                'children' => [],
            ]);
        }

        if ($this->request->getQuery('category') == 17) // خانه و ویلا
        {
            $this->response->setJsonContent([
                'id' => 17,
                'title' => 'خانه و ویلا',
                'parent_id' => 4,
                'parent_title' => 'اجاره مسکونی',
                'count_child' => 0,
            ]);
        }

        if ($this->request->getQuery('category') == 11) // زمین و کلنگی
        {
            $this->response->setJsonContent([
                'id' => 11,
                'title' => 'زمین و کلنگی',
                'parent_id' => 3,
                'parent_title' => 'فروش مسکونی',
                'count_child' => 0,
                'children' => [],
            ]);
        }

        if ($this->request->getQuery('category') == 2) // وسایل نقلیه
        {
            $this->response->setJsonContent([
                'id' => 2,
                'title' => 'وسایل نقلیه',
                'parent_id' => null,
                'parent_title' => null,
                'count_child' => 4,
                'children' => [
                    [
                        'id' => 7,
                        'title' => 'خودرو',
                        'parent_id' => 2,
                        'parent_title' => 'وسایل نقلیه',
                        'count_child' => 4,
                    ],
                    [
                        'id' => 8,
                        'title' => 'موتور سیکلت',
                        'parent_id' => 2,
                        'parent_title' => 'وسایل نقلیه',
                        'count_child' => 0,
                    ]
                ]
            ]);
        }

        if ($this->request->getQuery('category') == 7) // خودرو
        {
            $this->response->setJsonContent([
                'id' => 7,
                'title' => 'خودرو',
                'parent_id' => 2,
                'parent_title' => 'وسایل نقلیه',
                'count_child' => 4,
                'children' => [
                    [
                        'id' => 12,
                        'title' => 'سواری',
                        'parent_id' => 7,
                        'parent_title' => 'خودرو',
                        'count_child' => 0,
                    ],
                    [
                        'id' => 13,
                        'title' => 'سنگین',
                        'parent_id' => 7,
                        'parent_title' => 'خودرو',
                        'count_child' => 0,
                    ],
                    [
                        'id' => 14,
                        'title' => 'اجاره ای',
                        'parent_id' => 7,
                        'parent_title' => 'خودرو',
                        'count_child' => 0,
                    ],
                    [
                        'id' => 15,
                        'title' => 'کلاسیک',
                        'parent_id' => 7,
                        'parent_title' => 'خودرو',
                        'count_child' => 0,
                    ]
                ]
            ]);
        }

        if ($this->request->getQuery('category') == 12) // سواری
        {
            $this->response->setJsonContent([
                'id' => 12,
                'title' => 'سواری',
                'parent_id' => 7,
                'parent_title' => 'خودرو',
                'count_child' => 0,
                'children' => [],
            ]);
        }

        if ($this->request->getQuery('category') == 13) // سنگین
        {
            $this->response->setJsonContent([
                'id' => 13,
                'title' => 'سنگین',
                'parent_id' => 7,
                'parent_title' => 'خودرو',
                'count_child' => 0,
                'children' => [],
            ]);
        }

        if ($this->request->getQuery('category') == 14) // اجاره ای
        {
            $this->response->setJsonContent([
                'id' => 14,
                'title' => 'اجاره ای',
                'parent_id' => 7,
                'parent_title' => 'خودرو',
                'count_child' => 0,
                'children' => [],
            ]);
        }

        if ($this->request->getQuery('category') == 15) // کلاسیک
        {
            $this->response->setJsonContent([
                'id' => 15,
                'title' => 'کلاسیک',
                'parent_id' => 7,
                'parent_title' => 'خودرو',
                'count_child' => 0,
                'children' => [],
            ]);
        }

        if ($this->request->getQuery('category') == 8) // موتور سیکلت
        {
            $this->response->setJsonContent([
                'id' => 8,
                'title' => 'موتور سیکلت',
                'parent_id' => 2,
                'parent_title' => 'وسایل نقلیه',
                'count_child' => 0,
                'children' => [],
            ]);
        }

        $this->response->setContentType('application/json');
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->send();
        $this->view->disable();
        die;
    }

    public function inputAction()
    {
        $this->response->setJsonContent([
            [
                'id' => null,
                'title' => 'همه',
                'parent_id' => null,
                'count_child' => 3
            ],
            [
                'id' => 2,
                'title' => 'املاک',
                'parent_id' => null,
                'count_child' => 0
            ],
            [
                'id' => 3,
                'title' => 'وسایل نقلیه',
                'parent_id' => null,
                'count_child' => 0
            ],
            [
                'id' => 4,
                'title' => 'لوازم الکترونیکی',
                'parent_id' => null,
                'count_child' => 2
            ],
            [
                'id' => 5,
                'title' => 'رایانه',
                'parent_id' => 4,
                'count_child' => 0
            ],
            [
                'id' => 6,
                'title' => 'کنسول',
                'parent_id' => 4,
                'count_child' => 2
            ],
            [
                'id' => 7,
                'title' => 'ps4',
                'parent_id' => 6,
                'count_child' => 0
            ],
            [
                'id' => 8,
                'title' => 'xbox',
                'parent_id' => 6,
                'count_child' => 0
            ]
        ]);
        $this->response->setContentType('application/json');
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->send();
        $this->view->disable();
        die;
    }

    public function menuAction()
    {
        $categories = ModelCategory::find();


        $this->response->setJsonContent(
            array_merge(
                [
                    [
                        'id' => null,
                        'parent_id' => null,
                        'child' => count(
                            ModelCategory::find(['conditions'=> 'parent_id IS NULL'])->toArray()
                        ),
                        'title' => 'همه آگهی‌ها'
                    ]
                ],
                Arrays::treeFlat($categories->toArray())
            )
        );
        $this->response->setContentType('application/json');
//        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->send();
        $this->view->disable();
        die;
    }
}