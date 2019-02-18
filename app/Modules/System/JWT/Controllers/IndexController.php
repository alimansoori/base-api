<?php
namespace Modules\System\JWT\Controllers;


use Lib\Mvc\Controller;
use Modules\System\JWT\Models\ModelJWT;

class IndexController extends Controller
{
    public function indexAction()
    {
        $jwt = new ModelJWT();
        $jwt->setUserid(1);
        $jwt->setContent('gjkjkjgk');

        if (!$jwt->save())
        {
            dump($jwt->getMessages());
        }

        dump($jwt->toArray());
    }
}