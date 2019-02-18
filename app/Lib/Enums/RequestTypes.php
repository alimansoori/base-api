<?php
namespace Lib\Enums;

abstract class RequestTypes extends BasicEnum
{
    const GET     = 'GET';
    const POST    = 'POST';
    const PUT     = 'PUT';
    const DELETE  = 'DELETE';
    const PATCH   = 'PATCH';
    const HEAD    = 'HEAD';
    const OPTIONS = 'OPTIONS';
}