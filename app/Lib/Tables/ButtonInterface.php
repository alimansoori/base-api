<?php
namespace Lib\Tables;



use Lib\Tables\Buttons\Button;

interface ButtonInterface
{
    public function initButtons(): void ;

    /**
     * @return Button[]
     */
    public function getButtons(): array ;

    /**
     * @param string $key
     * @return Button
     * @throws Exception
     */
    public function getButton(string $key);
    public function addButton(Button $button);

//    public function addButtons(array $buttons, $merge = true);
    public function hasButton(string $key): bool ;
}