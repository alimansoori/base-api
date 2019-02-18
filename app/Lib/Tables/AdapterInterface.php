<?php
namespace Lib\Tables;


interface AdapterInterface
{
    public function init(): void;
    public function setName(string $name): void;
    public function getName(): string;
    public function render(): string;
    public function beforeProcess(): void;
    public function process(bool $status=false);
    public function getClassNames(): array;
    public function setClassNames(array $classNames): void;
    public function addClassName(string $className);
    public function hasClassName(string $className);
}