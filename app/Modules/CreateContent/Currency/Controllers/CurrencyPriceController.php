<?php
namespace Modules\CreateContent\Currency\Controllers;

use Lib\Mvc\Controllers\AdminController;

class CurrencyPriceController extends AdminController
{
    public function getAction()
    {
        die(
            json_encode([
                'data' => [
                    [
                        'id' => 1,
                        'title' => 'cat-3'
                    ]
                ]
            ])
        );
    }

    public function createAction()
    {

    }

    public function editAction()
    {

    }

    public function removeAction()
    {

    }
}