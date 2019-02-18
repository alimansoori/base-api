<?php

namespace Lib\Events\Application;


use Lib\Mvc\Application;
use Phalcon\Events\EventInterface;
use Phalcon\Mvc\ControllerInterface;
use Phalcon\Mvc\DispatcherInterface;

class BeforeHandleRequest
{
    public function __construct(EventInterface $event, Application $application, DispatcherInterface $dispatcher)
    {
    }
}