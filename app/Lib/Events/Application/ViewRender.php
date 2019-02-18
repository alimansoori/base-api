<?php

namespace Lib\Events\Application;


use Lib\Mvc\Application;
use Phalcon\Events\EventInterface;
use Phalcon\Mvc\ViewInterface;

class ViewRender
{
    public function __construct(EventInterface $event, Application $application, ViewInterface $view)
    {
    }
}