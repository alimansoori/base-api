<?php
namespace Lib\DTE\Editor;


use Lib\DTE\Editor;
use Lib\DTE\Table;
use Lib\Forms\Element;

class Form extends \Phalcon\Forms\Form
{
    /** @var Editor */
    protected $editor;
    /** @var Table */
    protected $table;

    public function render( $name = null, $attributes = null )
    {
        $idForm = 'form'. ucfirst($this->getEditor()->getName());

//        parent::render( $name, $attributes );
        $output = "<div id='$idForm'>";
        /** @var Element $element */
        foreach($this->getElements() as $element)
            {
                $output .= $element->renderForEditor();
            }
        $output .= "</div>";

        return $output;
    }

    /**
     * @return Editor
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @param Editor $editor
     */
    public function setEditor( Editor $editor )
    {
        $this->editor = $editor;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param Table $table
     */
    public function setTable( Table $table )
    {
        $this->table = $table;
    }

}