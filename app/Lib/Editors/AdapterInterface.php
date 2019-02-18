<?php
namespace Lib\Editors;


use Lib\Editors\Fields\Field;

interface AdapterInterface
{
    public function init(): void;
    public function setName(string $name): void;
    public function getName(): string;
    public function render(): string;
    public function beforeRender(): void ;
    public function beforeProcess(): void;
    public function process();
    public function setCustomAssets();
    public function processAssets();
    public function getClassNames(): array;
    public function setClassNames(array $classNames): void;
    public function addClassName(string $className);
    public function hasClassName(string $className);

    // Fields

    public function initFields(): void;

    /**
     * @return Field[]
     */
    public function getFields(): array ;

    public function setFields(array $fields): void ;
    public function addField(Field $fields): void ;
    public function getField(string $name): Field;
    public function hasField(string $name): bool ;
    public function removeField(string $name): void ;

    public function initAjax(): void;
}