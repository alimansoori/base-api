<?php
namespace Lib\Events\Dispatcher;


use Lib\Mvc\Dispatcher;
use Phalcon\Events\EventInterface;
use Phalcon\Mvc\DispatcherInterface;

class AfterExecuteRoute
{
    /**
     * AfterExecuteRoute constructor.
     * @param EventInterface $event
     * @param DispatcherInterface|Dispatcher $dispatcher
     */
    public function __construct(EventInterface $event, DispatcherInterface $dispatcher)
    {
    }
}