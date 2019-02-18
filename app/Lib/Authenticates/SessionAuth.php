<?php
namespace Lib\Authenticates;


use Lib\Messages\Message;

class SessionAuth extends Auth
{

    /**
     * Returns loggedIn userID
     *
     * @return int|boolean
     */
    public function getUserId()
    {
        if (!$this->isLoggedIn()) {
            return false;
        }

        return $this->getDI()->getShared("session")->get("auth_userID");
    }

    /**
     * @return boolean
     */
    public function isLoggedIn()
    {
        $isLogin = $this->getDI()->getShared("session")->has("auth_userID");

        if(!$isLogin)
        {
            $this->getMessages()->appendMessage(new Message('user is not login'));
        }
        return $isLogin;
    }

    /**
     * @param $userID
     * @return void
     */
    public function registerSavedArray($userID)
    {
        $this->getDI()->getShared("session")->set(
            "auth_userID",
            $userID
        );
    }

    /** @return boolean */
    public function removeSavedArray()
    {
         return $this->getDI()->getShared("session")->remove("auth_userID");
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getFromRegisterArray( $key )
    {
        // TODO: Implement getFromRegisterArray() method.
    }

    public function getToken()
    {
        // TODO: Implement getToken() method.
    }
}