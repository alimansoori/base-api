<?php

namespace Lib\Events\Application;


use Lib\Mvc\Application;
use Phalcon\Events\EventInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;

class AfterStartModule
{
    public function __construct(EventInterface $event, Application $application, ModuleDefinitionInterface $moduleDefinition)
    {
    }
}