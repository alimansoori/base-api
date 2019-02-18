<?php
namespace Lib\Editors;


interface OptionsInterface
{
    /**
     * @return array
     */
    public function getOptions(): array ;
    public function setOptions(array $options): void;
    public function getOption(string $key);
    public function addOptions(array $options): void ;
    public function addOption(string $key, $value): void ;
    public function setOption(string $key, $value): void ;
    public function isOption(string $key): bool;
}