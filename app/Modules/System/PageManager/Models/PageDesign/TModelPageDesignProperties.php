<?php
namespace Modules\System\PageManager\Models\PageDesign;


trait TModelPageDesignProperties
{
    private $id;
    private $page_id;
    private $template;

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
    public function setPageId( $page_id )
    {
        $this->page_id = $page_id;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate( $template )
    {
        $this->template = $template;
    }
}