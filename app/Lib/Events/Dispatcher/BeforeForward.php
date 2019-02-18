<?php
namespace Lib\Events\Dispatcher;


use Phalcon\Events\EventInterface;
use Phalcon\Mvc\DispatcherInterface;

class BeforeForward
{
    public function __construct(EventInterface $event, DispatcherInterface $dispatcher, array $forward)
    {
    }
}