<?php
namespace Modules\System\Users\Models;

use Lib\Authenticates\Auth;
use Lib\Mvc\Model;
use Modules\System\Users\Models\Users\Events;
use Modules\System\Users\Models\Users\Properties;
use Modules\System\Users\Models\Users\Relations;
use Modules\System\Users\Models\Users\Validations;
use Phalcon\Di;

class ModelUsers extends Model
{
    use Properties;
    use Relations;
    use Validations;
    use Events;

    protected function init()
    {
        $this->setDbRef(true);
        $this->setSource('users');
    }

    public function setPassword($password)
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

    public function checkPassword($password)
    {
        if ($password === $this->getPassword())
            return true;

        return false;
    }

    public function getAuthData()
    {
        $authData = new \stdClass();
        $authData->id = $this->getId();
        $authData->username = $this->getUsername();
        $authData->email    = $this->getEmail();
        return $authData;
    }

    public static function findUserWithUsernameOrEmail($user_email)
    {
        return self::findFirst(
            [
                "(username = :user_email: OR email = :user_email:)",
                'bind' => [
                    'user_email' => $user_email
                ]
            ]
        );
    }

    public static function getUserRolesForAuth()
    {
        /** @var Auth $auth */
        $auth = Di::getDefault()->getShared('auth');

        $roles = [];
        if($auth->isLoggedIn())
        {
            if($auth->getUser())
            {
                $roles = $auth->getUser()->getRoles()->toArray();
                if(!empty($roles))
                {
                    $roles = array_column($roles, 'name');
                }
            }
        }
        else
        {
            $roles[] = 'guest';
        }

        return $roles;
    }

    public static function getUsersTableInformation()
    {
        /** @var ModelUsers[] $users */
        $users = self::find();

        $row = [];

        foreach( $users as $user )
        {
            $row[] = self::getUserForTable($user);
        }

        return $row;
    }

    public static function getUserForTable(ModelUsers $user)
    {
        return array_merge(
            [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'created' => $user->getCreated(),
                'status' => $user->getStatus()
            ],
            $user->getSettingInformation( [
                'columns' => [
                    'user_id as DT_RowId',
                    'time_zone as setting_time_zone',
                    'language_iso as setting_language'
                ]
            ] )->toArray(),
            $user->getCompanyInformation( [
                'columns' => [
                    'type as company_type',
                    'name as company_name',
                    'economic_code as company_economic_code',
                    'national_code as company_national_code',
                    'register_code as company_register_code',
                    'responsibility as company_responsibility',
                    'personnel_code as company_personnel_code'
                ]
            ] )->toArray(),
            $user->getPersonalInformation( [
                'columns' => [
                    'first_name',
                    'last_name',
                    'parent_name',
                    'id_number',
                    'place_of_birth',
                    'gender',
                    'date_of_birth',
                    'national_code',
                    'mobile',
                    'phone',
                    'fax',
                    'state',
                    'city',
                    'postal_code',
                    'address'
                ]
            ] )->toArray(),
            $user->getEducationalInformation( [
                'columns' => [
                    'level as educational_level',
                    'field as educational_field'
                ]
            ] )->toArray(),
            $user->getFurtherInformation( [
                'columns' => [
                    'profile_url',
                    'blog_address',
                    'signature',
                    'favorites',
                    'avatar_address',
                    'description'
                ]
            ] )->toArray()
        );
    }

    public static function isUser(int $userId): bool
    {
        $user = self::findFirst($userId);
        if($user) return true;
        return false;
    }

    /**
     * @return bool
     */
    public function isFullName()
    {
        if ($this->getPersonalInformation()->getFirstName() || $this->getPersonalInformation()->getLastName())
        {
            return true;
        }

        return false;
    }

    /**
     * @return null|string
     */
    public function getFullName()
    {
        if ($this->getPersonalInformation()->getFirstName() || $this->getPersonalInformation()->getLastName())
        {
            return $this->getPersonalInformation()->getFirstName(). ' '. $this->getPersonalInformation()->getLastName();
        }

        return null;
    }
}