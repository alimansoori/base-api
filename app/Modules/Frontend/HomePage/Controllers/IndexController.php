<?php
namespace Modules\Frontend\HomePage\Controllers;

use Phalcon\Assets\Collection;
use Lib\Mvc\Controller;

/**
 * @property Collection $assetsCollection
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        dump($this->auth->isLoggedIn());
        if ($this->auth->logIn('admin', '123456789'))
        {
            $data = [
                'token' => $this->auth->getToken()
            ];

            $this->restResponse->offsetSet('data', $data);
        }
//        $this->restResponse->offsetSet('headers', $this->request->getHeaders());
//        dump($this->request->getHeader('Accept-Language'));

//        dump($this->request->getUploadedFiles());

//        dump($_REQUEST);
    }
}