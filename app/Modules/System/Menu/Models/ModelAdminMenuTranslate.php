<?php
namespace Modules\System\Menu\Models;


use Lib\Mvc\Model;
use Lib\Validation\Validator\UniquenessFor;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\StringLength;

/**
 * @method ModelLanguage    getLanguage()
 * @method ModelAdminMenu   getMenu()
 */
class ModelAdminMenuTranslate extends Model
{
    private $id;
    private $menu_id;
    private $language_iso;
    private $title;

    protected function init()
    {
        $this->setSource('admin_menu_translate');
        $this->setDbRef(true);
    }

    protected function relations()
    {
        $this->belongsTo(
            'menu_id',
            ModelAdminMenu::class,
            'id',
            [
                'alias' => 'Menu',
                'foreignKey' => [
                    'message' => 'This menu does not exist',
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
            'menu_id',
            new InclusionIn([
                'domain' => array_column(ModelAdminMenu::find(['columns' => 'id'])->toArray(), 'id')
            ])
        );

        $this->validator->add(
            'menu_id',
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
    public function getMenuId()
    {
        return $this->menu_id;
    }

    /**
     * @param mixed $menu_id
     */
    public function setMenuId($menu_id): void
    {
        $this->menu_id = $menu_id;
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