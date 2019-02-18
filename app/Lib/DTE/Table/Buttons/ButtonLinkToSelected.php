<?php
namespace Lib\DTE\Table\Buttons;


use Lib\DTE\Table\Button;

class ButtonLinkToSelected extends Button
{
    protected $_url;

    public function __construct(string $name, $linkTo = null)
    {
        parent::__construct($name);
        $this->setExtend('selected');

        if($linkTo)
            $this->_url = $linkTo;
        else
        {
            $this->_url = $this->url->get([
                'for' => $this->router->getMatchedRoute()->getName()
            ]);
        }
    }

    public function init()
    {
        parent::init();

        $this->setAction( /** @lang text */
            "
                var id = {$this->getTable()->getName()}.row( {selected: true} ).data().id;
                window.location.href = '{$this->getUrl()}' + '/' + id;
            ");
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl( $url )
    {
        $this->_url = $url;
    }
}