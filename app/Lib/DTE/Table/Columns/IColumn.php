<?php
namespace Lib\DTE\Table\Columns;

use Lib\DTE\Table;

interface IColumn
{
    /**
     * Sets the parent Table to the column
     *
     * @param Table $table
     * @return $this
     */
    public function setTable( Table $table);

    /**
     * Returns the parent Table to the column
     *
     * @return Table
     */
    public function getTable();

    /**
     * Sets the column's name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Returns the column's name
     * @return string
     */
    public function getName();

    /**
 * Sets the column's data
 *
 * @param string $data
 * @return $this
 */
    public function setData($data);

    /**
     * Returns the column's data
     * @return string
     */
    public function getData();

    /**
     * Sets the column's visible
     *
     * @param string $visible
     * @return $this
     */
    public function setVisible($visible);

    /**
     * Returns the column's visible
     * @return bool
     */
    public function isVisible();

    /**
     * Sets the column's render
     *
     * @param string $render
     * @return $this
     */
    public function setRender($render);

    /**
     * Returns the column's render
     * @return string
     */
    public function getRender();

    public function init();

    public function toArray();
}