<?php
namespace Lib\Translate;


use Lib\Translate\Adapter\NativeArray;
use Phalcon\Di;
use Phalcon\Mvc\User\Component;

class T extends Component
{
    public static function _($translateKey, $placeholders = [])
    {
        /** @var NativeArray $t */
        $t = Di::getDefault()->getShared('t');

        return $t->_($translateKey, $placeholders);
    }
}