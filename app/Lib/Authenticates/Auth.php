<?php
namespace Lib\Authenticates;

use Lib\Messages\Message;
use Lib\Messages\Messages;
use Lib\Mvc\Model\ModelUsers;
use Phalcon\Di\Injectable;
use Phalcon\DiInterface;
use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mvc\ModelInterface;

abstract class Auth extends Injectable implements EventsAwareInterface, IAuth
{
    /** @var ManagerInterface */
    protected $_eventsManager;

    /** @var string */
    protected $modelName;

    /** @var string */
    protected $usernameField;

    protected $emailField;

    /** @var string */
    protected $passwordField;

    /** @var string */
    protected $userIdField;

    /** @var array  */
    protected $payload = [];

    /** @var Messages */
    protected $messages;

    /**
     * @param string $modelName
     * @param string $usernameField
     * @param string $emailField
     * @param string $passwordField
     * @param string $userIdField
     *
     * @throws Exception
     */
    public function __construct($modelName, $usernameField, $emailField, $passwordField, $userIdField)
    {
        $di = $this->getDI();
        if(! $di instanceof DiInterface)
            throw new Exception('A dependency injection object is required to access internal services');

        $this->userIdField   = $userIdField;
        $this->usernameField = $usernameField;
        $this->emailField    = $emailField;
        $this->passwordField = $passwordField;
        $this->modelName     = $modelName;

        $this->messages = new Messages();
    }

    /**
     * @return ManagerInterface
     */
    public function getEventsManager()
    {
        return $this->_eventsManager;
    }

    /**
     * @param ManagerInterface $eventsManager
     */
    public function setEventsManager( ManagerInterface $eventsManager )
    {
        $this->_eventsManager = $eventsManager;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function logIn( $username, $password )
    {
        if($this->getEventsManager() instanceof ManagerInterface)
        {
            if($this->getEventsManager()->fire("auth:beforeLogIn", $this) === false)
                return false;
        }

        if($this->isLoggedIn())
            return true;

        $user = $this->getUserFromCredentials($username, $password);

        if(!$user)
        {
            return false;
        }

        $this->payload[ 'user_id'] = $this->getUserIdFromUser($user);

        $this->registerSavedArray($this->payload[ 'user_id']);

        if($this->getEventsManager() instanceof ManagerInterface)
            $this->getEventsManager()->fire("auth:afterLogIn", $this);

        return true;
    }

    /**
     * @return bool
     */
    public function logOut()
    {
        if($this->getEventsManager() instanceof ManagerInterface)
        {
            if($this->getEventsManager()->fire("auth:beforeLogOut", $this) === false)
                return false;
        }

        if(!$this->isLoggedIn())
            return true;

        $this->removeSavedArray();

        if($this->getEventsManager() instanceof ManagerInterface)
            $this->getEventsManager()->fire("auth:afterLogOut", $this);

        return true;
    }

    /**
     * @return ModelUsers|bool
     */
    public function getUser()
    {
        if(!$this->isLoggedIn())
        {
            return false;
        }

        return $this->getUserFromUserId($this->getUserId());
    }

    public function getUserFromCredentials( $username, $password )
    {
        $user = ModelUsers::getUserByUsernameOREmail($username);

        if(!$user)
        {
            $this->getMessages()->appendMessage(
                new Message('User does not found')
            );
            return false;
        }

        if($password !== $user->getPassword())
            return false;

        return $user;
    }

    /**
     * @param ModelInterface|ModelUsers $user
     * @param $newPassword
     * @return bool
     * @throws \Lib\Messages\Exception
     */
    public function changePassword(ModelInterface $user, $newPassword)
    {
        $eventsManager = $this->getEventsManager();

        if ($eventsManager instanceof ManagerInterface) {
            if ($eventsManager->fire("auth:beforeChangePassword", $this) === false) {
                return false;
            }
        }

        $user->setPassword($newPassword);

        $success = $user->update();

        if(!$success)
        {
            $this->getMessages()->appendMessages($user->getMessages());
            return false;
        }



        if ($eventsManager instanceof ManagerInterface) {
            $eventsManager->fire("auth:afterChangePassword", $this);
        }

        return $success;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload( $payload )
    {
        $this->payload = $payload;
    }

    /**
     * @return Messages
     */
    public function getMessages(): Messages
    {
        return $this->messages;
    }

    /**
     * @param Message $message
     */
    public function appendMessage( Message $message ): void
    {
        $this->messages->appendMessage($message);
    }


}