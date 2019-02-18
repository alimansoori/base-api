<?php
namespace Lib\Tables\Buttons;


use Lib\Common\Strings;

trait TButtonOptions
{
    protected $name;
    protected $namespace;
    protected $action;
    /** @var array */
    protected $attr;
    protected $available;
    protected $destroy;
    protected $enabled = true;
    protected $init;
    protected $tag;
    protected $extend;
    protected $className;
    protected $text;
    protected $key;
    protected $titleAttr;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    public function setAction($action, $type = self::TYPE_OPT_FUNCTION)
    {
        $this->action = "||function(e, dt, node, config){".Strings::multilineToSingleline($action)."}||";
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setInit($init)
    {
        $this->init = "||function(dt, node, config){".Strings::multilineToSingleline($init)."}||";
        return $this;
    }

    public function getInit()
    {
        return $this->init;
    }

    public function setClassName($className)
    {
        $this->className = $className;
        return $this;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function setExtend($extend)
    {
        $this->extend = $extend;
        return $this;
    }

    public function getExtend()
    {
        return $this->extend;
    }

    /**
     * @param array|string $key
     * @return TButtonOptions
     */
    public function setKey($key)
    {
        if(is_string($key))
            $this->key = $key;
        elseif(is_array($key))
        {
            $row = ['key','shiftKey', 'altKey','ctrlKey', 'metaKey'];
            foreach($key as $item=>$value)
            {
                if(in_array($item, $row))
                {
                    $this->key[$item] = $value;
                }
            }
        }
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getTitleAttr()
    {
        return $this->titleAttr;
    }

    /**
     * @param mixed $titleAttr
     * @param $type
     */
    public function setTitleAttr( $titleAttr, $type = self::TYPE_OPT_STRING )
    {
        if($type == self::TYPE_OPT_STRING)
        {
            $this->titleAttr = $titleAttr;
        }
        elseif($type == self::TYPE_OPT_FUNCTION)
        {
            $this->titleAttr = "||".Strings::multilineToSingleline($titleAttr)."||";
        }
    }

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

    public function addAttr($key, $value)
    {
        $this->attr[$key] = $value;
    }

    public function setAvailable($available)
    {
        $this->available = "||function(dt, config){".Strings::multilineToSingleline($available)."}||";
        return $this;
    }

    public function getAvailable()
    {
        return $this->available;
    }

    public function setDestroy($destroy)
    {
        $this->destroy = "||function(dt, node, config){".Strings::multilineToSingleline($destroy)."}||";
        return $this;
    }

    public function getDestroy()
    {
        return $this->destroy;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled( $enabled )
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace( $namespace )
    {
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag( $tag )
    {
        $this->tag = $tag;
    }

    public function toArray()
    {
        $this->init();

        $row = [];

        if($this->name)
            $row['name'] = $this->name;

        if($this->namespace)
            $row['namespace'] = $this->namespace;

        if($this->action)
            $row['action'] = $this->action;

        if(is_array($this->attr))
            $row['attr'] = $this->attr;

        if($this->available)
            $row['available'] = $this->available;

        if($this->destroy)
            $row['destroy'] = $this->destroy;

        if(!$this->isEnabled())
            $row['enabled'] = $this->enabled;

        if($this->init)
            $row['init'] = $this->init;

        if($this->tag)
            $row['tag'] = $this->tag;

        if($this->extend)
            $row['extend'] = $this->extend;

        if($this->text)
            $row['text'] = $this->text;

        if($this->key)
            $row['key'] = $this->key;

        if($this->className)
            $row['className'] = $this->className;

        if($this->titleAttr)
            $row['titleAttr'] = $this->titleAttr;

        return $row;
    }
}