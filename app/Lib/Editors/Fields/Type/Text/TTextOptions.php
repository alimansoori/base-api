<?php
namespace Lib\Editors\Fields\Type\Text;

use Lib\Exception;

trait TTextOptions
{
    protected $attr = [];

    /**
     * @return array
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * @param array $attr
     */
    public function setAttr( $attr )
    {
        $this->attr = $attr;
    }

    public function addAttrs($attr)
    {
        if(!is_array($attr))
            throw new Exception('attr must be array key value');

        $this->attr = array_merge($this->attr, $attr);
    }
}