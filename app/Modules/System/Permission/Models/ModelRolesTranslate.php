<?php
namespace Modules\System\Permission\Models;


use Lib\Mvc\Model;
use Lib\Validation\Validator\UniquenessFor;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Permission\Models\ModelRoles;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\StringLength;

/**
 * @method ModelLanguage    getLanguage()
 * @method ModelRoles       getRole()
 */
class ModelRolesTranslate extends Model
{
    private $id;
    private $role_id;
    private $language_iso;
    private $title;

    protected function init()
    {
        $this->setSource('roles_translate');
    }

    protected function relations()
    {
        $this->belongsTo(
            'role_id',
            ModelRoles::class,
            'id',
            [
                'alias' => 'Role',
                'foreignKey' => [
                    'message' => 'This role does not exist',
                ]
            ]
        );

        $this->belongsTo(
            'language_iso',
            ModelLanguage::class,
            'iso',
            [
                'alias' => 'Language',
                'foreignKey' => [
                    'message' => 'This language does not exist',
                ]
            ]
        );
    }

    protected function mainValidation()
    {
        $this->validator->add(
            'role_id',
            new InclusionIn([
                'domain' => array_column(ModelRoles::find(['columns' => 'id'])->toArray(), 'id')
            ])
        );

        $this->validator->add(
            'role_id',
            new UniquenessFor([
                'model' => $this,
                'fields' => [
                    'language_iso'
                ]
            ])
        );

        $this->validator->add(
            'language_iso',
            new InclusionIn([
                'domain' => ModelLanguage::getLanguages()
            ])
        );

        $this->validator->add(
            'title',
            new StringLength([
                'max' => 50
            ])
        );
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
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId($role_id): void
    {
        $this->role_id = $role_id;
    }

    /**
     * @return mixed
     */
    public function getLanguageIso()
    {
        return $this->language_iso;
    }

    /**
     * @param mixed $language_iso
     */
    public function setLanguageIso($language_iso): void
    {
        $this->language_iso = $language_iso;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }
}