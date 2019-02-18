<?php
namespace Lib;

use Lib\Translate\T;
use Phalcon\Text;

class Validation extends \Phalcon\Validation
{
    public function setDefaultMessages( $messages = [] )
    {
        $this->_defaultMessages = parent::setDefaultMessages( $messages );
        $this->_defaultMessages['UniquenessFor'] = "Field :field must be unique by list: :fields";

        $newMessages = [];
        foreach($this->_defaultMessages as $type=>$message)
        {
            $newMessages[$type] = T::_(str_replace(':','', Text::lower(Text::underscore($message))));
        }

        $this->_defaultMessages = $newMessages;

        return $this->_defaultMessages;
    }
}