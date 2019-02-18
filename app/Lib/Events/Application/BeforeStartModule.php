<?php

namespace Lib\Events\Application;


use Lib\Mvc\Application;
use Phalcon\Events\EventInterface;

class BeforeStartModule
{
    public function __construct(EventInterface $event, Application $application, $moduleName)
    {
    }
}