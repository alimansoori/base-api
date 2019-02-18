<?php
namespace Modules\Projekt\CodePlayer\Controllers;


use Lib\Exception;
use Lib\Mvc\Controller;
use Modules\Projekt\CodePlayer\Models\ModelCodeplayer;

class CodeplayerDeleteController extends Controller
{
    private $resData = [];

    public function indexAction()
    {
        try {
            $id = $this->dispatcher->getParam('id');

            if (!is_numeric($id))
            {
                throw new Exception('access denied', 404);
            }

            /** @var ModelCodeplayer $codePlayer */
            $codePlayer = ModelCodeplayer::findFirst($id);

            if (!$codePlayer) // data not found
            {
                throw new Exception('not exist', 404);
            }

            if (!$codePlayer->delete())
            {
                throw new Exception('not delete', 404);
            }

            // data found
            $this->response->setStatusCode(204);

        } catch (Exception $exception) {
            $this->resData['code'] = $exception->getCode();
            $this->resData['message'] = $exception->getMessage();
            if ($exception->getCode()) $this->response->setStatusCode($exception->getCode());
        }

        $this->response->setJsonContent($this->resData);
        $this->response->send();
        die;
    }
}