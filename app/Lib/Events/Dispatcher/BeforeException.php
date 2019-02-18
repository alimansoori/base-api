<?php
namespace Lib\Events\Dispatcher;


use Phalcon\Events\EventInterface;
use Phalcon\Exception;
use Phalcon\Mvc\DispatcherInterface;

class BeforeException
{
    public function __construct(EventInterface $event, DispatcherInterface $dispatcher, $exception)
    {
    }
}