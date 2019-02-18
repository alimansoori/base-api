<?php
namespace Lib\Events\Dispatcher;



use Phalcon\Events\EventInterface;
use Phalcon\Mvc\DispatcherInterface;

class BeforeDispatch
{
    public function __construct(EventInterface $event, DispatcherInterface $dispatcher)
    {
    }
}