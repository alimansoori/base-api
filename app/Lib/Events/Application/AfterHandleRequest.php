<?php

namespace Lib\Events\Application;


use Lib\Mvc\Application;
use Phalcon\Events\EventInterface;
use Phalcon\Mvc\ControllerInterface;

class AfterHandleRequest
{
    public function __construct(EventInterface $event, Application $application, ControllerInterface $controller)
    {
    }
}