<?php
namespace Lib\Tables;


interface OptionsInterface
{
    /**
     * @return array
     */
    public function getOptions(): array ;
    public function setOptions(array $options): void;
    public function getOption(string $key);
    public function addOptions(array $options);
    public function addOption(string $key, $value);
    public function isOption(string $key): bool;
}