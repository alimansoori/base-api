<?php
namespace Lib\DTE\Editor\Template;


use Lib\DTE\Editor\Fields\Field;

abstract class FieldComposite extends Field
{
    /** @var Field[] $fields */
    protected $fields = [];

    protected $name;
    protected $title;
    protected $id;

    protected $visible = true;

    public function __construct($name, $title)
    {
        $this->name = $name;
        $this->id = $name;
        $this->title = $title;
    }

    public function add(Field $field)
    {
        $name = $field->getName();
        $this->fields[$name] = $field;
    }

    public function remove(Field $component)
    {
        unset($this->fields[$component->getName()]);
    }

    public function render()
    {
        $output = "";

        foreach ($this->fields as $name => $field) {
            $output .= $field->render();
        }

        return $output;
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
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible( bool $visible ): void
    {
        $this->visible = $visible;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}