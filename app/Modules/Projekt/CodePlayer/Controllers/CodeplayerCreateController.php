<?php
namespace Modules\Projekt\CodePlayer\Controllers;


use Lib\Exception;
use Lib\Mvc\Controller;
use Modules\Projekt\CodePlayer\Models\ModelCodeplayer;

class CodeplayerCreateController extends Controller
{
    private $resData = [];

    public function indexAction()
    {
        try {
            $content = $this->request->getPost('content');

            if (empty($content))
            {
                throw new Exception('content is empty', 400);
            }

            $codePlayer = new ModelCodeplayer();
            $codePlayer->setContent($content);

            if (!$codePlayer->save()) // data not found
            {
                throw new Exception('not save', 400);
            }

            // data found
            $this->response->setStatusCode(201);
            $this->resData = $codePlayer->toArray();

        } catch (Exception $exception) {
            $this->resData['message'] = $exception->getMessage();
            if ($exception->getCode()) $this->response->setStatusCode($exception->getCode());
        }

        $this->response->setJsonContent($this->resData);
        $this->response->send();
        die;
    }
}