<?php
namespace Modules\Projekt\CodePlayer\Controllers;


use Lib\Exception;
use Lib\Mvc\Controller;
use Modules\Projekt\CodePlayer\Models\ModelCodeplayer;

class CodeplayerController extends Controller
{
    private $resData = [];

    public function indexAction()
    {
        try {
            $id = $this->dispatcher->getParam('id');

            if (!is_numeric($id))
            {
                throw new Exception('access denied', 400);
            }

            $codePlayer = ModelCodeplayer::findFirst($id);

            if (!$codePlayer) // data not found
            {
                throw new Exception('not exist', 404);
            }

            // data found
            $this->response->setStatusCode(200);
            $this->resData['data'] = $codePlayer->toArray();

        } catch (Exception $exception) {
            $this->resData['message'] = $exception->getMessage();
            if ($exception->getCode()) $this->response->setStatusCode($exception->getCode());
        }

        $this->response->setJsonContent($this->resData);
        $this->response->setContentType('application/json');
        $this->response->send();
        $this->view->disable();
        die;
    }
}