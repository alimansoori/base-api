<?php
namespace Lib\Events\Dispatcher;



use Phalcon\Events\EventInterface;
use Phalcon\Mvc\DispatcherInterface;

class AfterInitialize
{
    public function __construct(EventInterface $event, DispatcherInterface $dispatcher)
    {
    }
}