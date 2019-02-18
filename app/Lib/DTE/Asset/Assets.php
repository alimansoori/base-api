<?php
namespace Lib\DTE\Asset;


use Lib\Assets\Manager;

class Assets extends Manager
{
    public function __construct( array $options = null )
    {
        parent::__construct( null );
        $this->collection('top');
        $this->collection('bottom');
        $this->collection('main');

    }

    public function addInlineJsTop($content, $filter = true, $attributes = null)
    {
        $this->collection('top')->addInlineJs($content, $filter = true, $attributes = null);
    }
    public function getInlineJsTop()
    {
        return $this->collection('top')->getCodes();
    }

    public function addInlineJsMain($content, $filter = true, $attributes = null)
    {
        $this->collection('main')->addInlineJs($content, $filter = true, $attributes = null);
    }
    public function getInlineJsMain()
    {
        return $this->collection('main')->getCodes();
    }

    public function addInlineJsBottom($content, $filter = true, $attributes = null)
    {
        $this->collection('bottom')->addInlineJs($content, $filter = true, $attributes = null);
    }
    public function getInlineJsBottom()
    {
        return $this->collection('bottom')->getCodes();
    }
}