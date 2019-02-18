<?php
namespace Lib\Tables;


interface DomInterface
{
    public function setDom(string $dom):void ;
    public function getDom(): string ;
}