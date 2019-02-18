<?php
namespace Lib\Mvc\User;
use Lib\Assets\Collection;
use Lib\Authenticates\Auth;
use Lib\Mvc\Router;
use Phalcon\Mvc\Model\Transaction;

/**
 * @property Router router
 * @property Collection assetsCollection
 * @property Auth auth
 * @property Transaction transactions
 */
class Component extends \Phalcon\Mvc\User\Component
{

}