<?php
namespace Modules\System\Widgets\Models;


use Lib\Mvc\Model;
use Lib\Translate\T;
use Modules\System\Widgets\Models\Modules\Events;
use Modules\System\Widgets\Models\Modules\Relations;
use Modules\System\Widgets\Models\Modules\Validations;

class ModelModules extends Model
{
    private $id;
    private $name;
    private $title;
    private $description;
    private $path;
    private $namespace;
    private $position;

    use Relations;
    use Validations;
    use Events;

    protected function init()
    {
        $this->setSource('modules');
        $this->setDbRef(true);
    }

    public static function getModulesTableInformation()
    {
        /** @var ModelModules[] $modules */
        $modules = self::find();

        $row = [];

        foreach( $modules as $module )
        {
            $row[] = self::getModuleForTable($module);
        }

        return $row;
    }

    public static function getModuleForTable(ModelModules $module)
    {
        return [
            'DT_RowId' => $module->getId(),
            'id' => $module->getId(),
            'name' => $module->getName(),
            'title' => [
                'display' => T::_($module->getTitle()),
                'filter' => T::_($module->getTitle()),
                'sort' => T::_($module->getTitle()),
                '_' => $module->getTitle()
            ],
            'description' => [
                'display' => T::_($module->getDescription()),
                'filter' => T::_($module->getDescription()),
                'sort' => T::_($module->getDescription()),
                '_' => $module->getDescription()
            ],
            'position' => $module->getPosition()
        ];
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName( $name ): void
    {
        $this->name = $name;
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
    public function setTitle( $title ): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription( $description ): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath( $path ): void
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace( $namespace ): void
    {
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition( $position ): void
    {
        $this->position = $position;
    }
}