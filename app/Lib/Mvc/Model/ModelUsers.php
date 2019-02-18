<?php
namespace Lib\Mvc\Model;


use Lib\Mvc\Model;
use Lib\Mvc\ModelUsers\Validations;

class ModelUsers extends Model
{
    private $id;
    private $create_ip;
    private $email;
    private $username;
    private $password;
    private $avatar_id;
    private $avatar_width;
    private $avatar_height;
    private $logged_in;
    private $login_ip;
    private $created;
    private $modified;
    private $status;

    use Validations;

    protected function init()
    {
        $this->setSource('users');
        $this->setDbRef(true);
    }

    /**
     * @return bool|self
     */
    public static function getUserByUsernameOREmail($usernameEmail)
    {
        $user = ModelUsers::findFirst([
            'conditions' => 'username=:username: OR email=:email:',
            'bind' => [
                'username' => $usernameEmail,
                'email' => $usernameEmail
            ]
        ]);

        if (!$user) return false;

        return $user;
    }

    /**
     * @param $username
     * @param $email
     * @param $password
     * @return bool|self
     */
    public static function createUser($username, $email, $password)
    {
        $user = new self();

        $user->setUsername($username);
        $user->setEmail($email);

        $user->setPassword($password);

        if(!$user->create())
        {
            return false;
        }

        return $user;
    }

    /* * * * * * *  * * * * * * * *  * * * * * * * *
    /* GET SET
    /* * * * * * * * * * * * * * * * * * * * * * * *

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAvatarId()
    {
        return $this->avatar_id;
    }

    /**
     * @param mixed $avatar_id
     */
    public function setAvatarId($avatar_id)
    {
        $this->avatar_id = $avatar_id;
    }

    /**
     * @return mixed
     */
    public function getAvatarWidth()
    {
        return $this->avatar_width;
    }

    /**
     * @param mixed $avatar_width
     */
    public function setAvatarWidth($avatar_width)
    {
        $this->avatar_width = $avatar_width;
    }

    /**
     * @return mixed
     */
    public function getAvatarHeight()
    {
        return $this->avatar_height;
    }

    /**
     * @param mixed $avatar_height
     */
    public function setAvatarHeight($avatar_height)
    {
        $this->avatar_height = $avatar_height;
    }

    /**
     * @return mixed
     */
    public function getCreateIp()
    {
        return $this->create_ip;
    }

    /**
     * @param mixed $create_ip
     */
    protected function setCreateIp( $create_ip )
    {
        $this->create_ip = $create_ip;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail( $email )
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername( $username )
    {
        $this->username = $username;
    }

    public function setPassword( $password )
    {
        $this->password = $this->getDI()->get('crypt')->encryptBase64(
            $password,
            $this->getDI()->get('crypt')->getKey()
        );
    }

    public function getPassword()
    {
        return $this->getDI()->get('crypt')->decryptBase64(
            $this->password,
            $this->getDI()->get('crypt')->getKey()
        );
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    protected function setCreated( $created ): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    protected function setModified( $modified ): void
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getLoggedIn()
    {
        return $this->logged_in;
    }

    /**
     * @param mixed $logged_in
     */
    protected function setLoggedIn( $logged_in ): void
    {
        $this->logged_in = $logged_in;
    }

    /**
     * @return mixed
     */
    public function getLoginIp()
    {
        return $this->login_ip;
    }

    /**
     * @param mixed $login_ip
     */
    protected function setLoginIp( $login_ip ): void
    {
        $this->login_ip = $login_ip;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus( $status ): void
    {
        $this->status = $status;
    }
}