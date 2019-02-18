<?php

namespace Lib\Events\Application;


use Lib\Mvc\Application;
use Phalcon\Events\EventInterface;
use Phalcon\Http\ResponseInterface;

class BeforeSendResponse
{
    public function __construct(EventInterface $event, Application $application, ResponseInterface $response)
    {
    }
}