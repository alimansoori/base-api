<?php
namespace Lib\Events\Dispatcher;



use Phalcon\Events\EventInterface;
use Phalcon\Mvc\DispatcherInterface;

class AfterDispatch
{
    public function __construct(EventInterface $event, DispatcherInterface $dispatcher)
    {
    }
}