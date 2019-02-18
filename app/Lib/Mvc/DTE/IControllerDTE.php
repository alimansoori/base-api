<?php
namespace Lib\Mvc\DTE;


interface IControllerDTE
{
    public function init();
    public function indexAction();
    public function getAction();
    public function createAction();
    public function editAction();
    public function removeAction();
}