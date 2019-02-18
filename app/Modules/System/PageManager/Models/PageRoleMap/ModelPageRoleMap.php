<?php
namespace Modules\System\PageManager\Models\PageRoleMap;


use Lib\Mvc\Model;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\Permission\Models\ModelRoles;

/**
 * @method ModelPages getPage()
 * @method ModelRoles getRole()
 */
class ModelPageRoleMap extends Model
{
    private $id;
    private $page_id;
    private $role_id;

    public function init()
    {
        $this->setDbRef(true);
        $this->setSource('page_role_map');
    }

    public function mainValidation() {}

    protected function relations()
    {
        $this->belongsTo(
            'role_id',
            ModelRoles::class,
            'id',
            [
                'alias' => 'Role'
            ]
        );
        $this->belongsTo(
            'page_id',
            ModelPages::class,
            'id',
            [
                'alias' => 'page'
            ]
        );
    }

    public static function getRolesForResource( $resourceId)
    {
        /** @var ModelRoles[] $roles */
        $roles = ModelRoles::find([
            'conditions' => 'language_iso=:lang:',
            'order' => 'position',
            'bind' => [
                'lang' => ModelLanguage::getCurrentLanguage(),
            ]
        ]);

        $resourceRoles = [];

        foreach($roles as $role)
        {
            if ($role->getName() == 'admin') continue;

            $resourceRoles[] = self::getUpdateDataForTable($role, $resourceId);
        }

        return $resourceRoles;
    }

    public static function getUpdateDataForTable( ModelRoles $role, $userId)
    {
        $status = 1;

        /** @var ModelPageRoleMap $resourceRole */
        $resourceRole = self::findFirst([
            'conditions' => 'page_id=:page_id: AND role_id=:role_id:',
            'bind' => [
                'page_id' => $userId,
                'role_id' => $role->getId()
            ]
        ]);

        if(!$resourceRole)
        {
            $status = 0;
        }

        $roleResource = [
            'DT_RowId'      => $role->getId(),
            'id'            => $role->getId(),
            'title'         => $role->getTitle(),
            'module'        => T::_($role->getModule()->getTitle()),
            'status'        => $status
        ];

        return $roleResource;
    }

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
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * @param mixed $page_id
     */
    public function setPageId( $page_id ): void
    {
        $this->page_id = $page_id;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId( $role_id ): void
    {
        $this->role_id = $role_id;
    }
}