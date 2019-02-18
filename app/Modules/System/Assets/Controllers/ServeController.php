<?php
namespace Modules\System\Assets\Controllers;


use Lib\Mvc\Controller;

class ServeController extends Controller
{
    public function indexAction()
    {
        $blobId = $this->dispatcher->getParam('blob_id');

    }
}