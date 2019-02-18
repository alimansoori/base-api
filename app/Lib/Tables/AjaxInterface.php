<?php
namespace Lib\Tables;


interface AjaxInterface
{
    const TYPE_GET = 'GET';
    const TYPE_POST = 'POST';

    public function getUrl(): string ;
    public function setUrl(string $url): void ;
    public function addData(string $key, $value): void ;
    public function setType(string $type): void ;
    public function getType(): string ;
    public function setData(array $data = []): void ;
    public function getData($isArray=true) ;
    public function getDataSrc(): string ;
    public function setDataSrc(string $dataSrc): void ;
    public function getTable() ;
    public function process();
}