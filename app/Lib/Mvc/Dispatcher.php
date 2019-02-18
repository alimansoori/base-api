<?php
namespace Lib\Mvc;


use Lib\Events\Dispatcher\AfterDispatch;
use Lib\Events\Dispatcher\AfterDispatchLoop;
use Lib\Events\Dispatcher\AfterExecuteRoute;
use Lib\Events\Dispatcher\AfterInitialize;
use Lib\Events\Dispatcher\BeforeDispatch;
use Lib\Events\Dispatcher\BeforeDispatchLoop;
use Lib\Events\Dispatcher\BeforeException;
use Lib\Events\Dispatcher\BeforeExecuteRoute;
use Lib\Events\Dispatcher\BeforeForward;
use Lib\Events\Dispatcher\BeforeNotFoundAction;
use Phalcon\Events\EventInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mvc\DispatcherInterface;

class Dispatcher extends \Phalcon\Mvc\Dispatcher
{
    public function setEvents()
    {
        $eventsManager = $this->getEventsManager();

        if(!$eventsManager instanceof ManagerInterface)
            return false;

        $eventsManager->attach('dispatch:beforeDispatchLoop', function(EventInterface $event, DispatcherInterface $dispatcher){
            //            new DbManagerPlugin();
            new BeforeDispatchLoop($event, $dispatcher);
            //            new CheckAcl($di->getShared('acl'), $dispatcher, $di->getShared('view'));
        });

        $eventsManager->attach('dispatch:afterExecuteRoute', function(EventInterface $event, DispatcherInterface $dispatcher){
            new AfterExecuteRoute($event, $dispatcher);
        });

        $eventsManager->attach('dispatch:afterDispatch', function(EventInterface $event, DispatcherInterface $dispatcher){
            new AfterDispatch($event, $dispatcher);
        });

        $eventsManager->attach('dispatch:afterDispatchLoop', function(EventInterface $event, DispatcherInterface $dispatcher){
            new AfterDispatchLoop($event, $dispatcher);
        });

        $eventsManager->attach('dispatch:afterInitialize', function(EventInterface $event, DispatcherInterface $dispatcher){
            new AfterInitialize($event, $dispatcher);
        });

        $eventsManager->attach('dispatch:beforeException', function(EventInterface $event, DispatcherInterface $dispatcher, $exception){
            new BeforeException($event, $dispatcher, $exception);
        });

        $eventsManager->attach('dispatch:beforeExecuteRoute', function(EventInterface $event, DispatcherInterface $dispatcher){
            new BeforeExecuteRoute($event, $dispatcher);
        });

        $eventsManager->attach('dispatch:beforeDispatch', function(EventInterface $event, DispatcherInterface $dispatcher){
            new BeforeDispatch($event, $dispatcher);
        });

        $eventsManager->attach('dispatch:beforeForward', function(EventInterface $event, DispatcherInterface $dispatcher, array $forward){
            new BeforeForward($event, $dispatcher, $forward);
        });

        $eventsManager->attach('dispatch:beforeNotFoundAction', function(EventInterface $event, DispatcherInterface $dispatcher){
            new BeforeNotFoundAction($event, $dispatcher);
        });
    }
}