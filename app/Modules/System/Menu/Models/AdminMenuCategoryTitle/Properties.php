<?php
namespace Modules\System\Menu\Models\AdminMenuCategoryTitle;


trait Properties
{
    private $id;
    private $category_id;
    private $language_iso;
    private $title;

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
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id): void
    {
        $this->category_id = $category_id;
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