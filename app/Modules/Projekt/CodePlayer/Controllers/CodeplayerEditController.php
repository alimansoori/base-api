<?php
namespace Modules\Projekt\CodePlayer\Controllers;


use Lib\Exception;
use Lib\Mvc\Controller;
use Modules\Projekt\CodePlayer\Models\ModelCodeplayer;

class CodeplayerEditController extends Controller
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

            if (!$this->request->getPut('content'))
            {
                throw new Exception('no exist content', 404);
            }

            /** @var ModelCodeplayer $codePlayer */
            $codePlayer = ModelCodeplayer::findFirst($id);

            if (!$codePlayer) // data not found
            {
                throw new Exception('not exist', 404);
            }

            $codePlayer->setContent(
                $this->request->getPut('content')
            );

            if (!$codePlayer->save())
            {
                throw new Exception('not save', 404);
            }

            // data found
            $this->response->setStatusCode(200);
            $this->resData = $codePlayer->toArray();

        } catch (Exception $exception) {
            $this->resData['error'] = $exception->getMessage();
            if ($exception->getCode()) $this->response->setStatusCode($exception->getCode());
        }

        $this->response->setJsonContent($this->resData);
        $this->response->send();
        die;
    }
}