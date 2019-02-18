<?php
namespace Lib\Mvc\Router;


use Phalcon\Mvc\ViewInterface;

class Route extends \Phalcon\Mvc\Router\Route
{
    protected $_attributes = [];
    /**
     * This request is called from the MatchedRoute event
     *
     * This method will prepare the view for Ajax request
     *
     * @param ViewInterface $view
     */
    public function disableViewForJsonResponse(ViewInterface $view)
    {
        $methods = [];
        if(!is_array($this->getHttpMethods()))
        {
            $methods[0] = $this->getHttpMethods();
        }
        else
        {
            $methods = $this->getHttpMethods();
        }

        $defaultMethods = ['GET','POST','PUT','PATCH','DELETE','OPTIONS','HEAD','PURGE','TRACE','CONNECT'];
        foreach($methods as $method)
        {
            if(in_array($method, $defaultMethods))
            {
                $view->disable();
                break;
            }
        }
    }

    public static function splitRouteNameFor($routeName, $delimiter = '__')
    {
        $explode = explode($delimiter, $routeName);
        return [
            'name' => $explode[0],
            'lang' => $explode[1]
        ];
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->_attributes;
    }

    /**
     * @param array $attributes
     * @return Route
     */
    public function setAttributes(array $attributes): Route
    {
        $this->_attributes = $attributes;

        return $this;
    }
}