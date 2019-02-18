<?php
namespace Lib\Events\Dispatcher;



use Phalcon\Events\EventInterface;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\User\Plugin;

class AfterDispatchLoop extends Plugin
{
    public function __construct(EventInterface $event, DispatcherInterface $dispatcher)
    {
        echo $this->response->getContent();
    }
}