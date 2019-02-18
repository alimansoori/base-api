<?php
namespace Lib\Authenticates;


use Phalcon\Mvc\ModelInterface;

interface IAuth
{
    /**
     * Login to application
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function logIn($username, $password);

    /** @return boolean */
    public function logOut();

    /**
     * Returns loggedIn user
     *
     * @return ModelInterface|boolean
     */
    public function getUser();

    /**
     * Returns loggedIn userID
     *
     * @return int|boolean
     */
    public function getUserId();

    /**
     * @return boolean
     */
    public function isLoggedIn();

    /**
     * @param string $username
     * @param string $password
     * @return ModelInterface|boolean
     */
    public function getUserFromCredentials($username, $password);

    /**
     * @param \Phalcon\Mvc\ModelInterface $user
     * @param string                      $newPassword
     *
     * @return boolean
     */
    public function changePassword(ModelInterface $user, $newPassword);

    /**
     * @param array $savedArray
     */
    public function setPayload($savedArray);

    /**
     * @return array
     */
    public function getPayload();

    public function getToken();
}