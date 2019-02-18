<?php
namespace Modules\System\Users\Editor\SettingInformation;


use Lib\DTE\Editor\Fields\Type\Select;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

trait TFields
{
    protected function fieldTimeZone()
    {
        $field = new Text('setting_time_zone');
        $field->setLabel(T::_('time_zone'));

        $this->addField($field);
    }

    protected function fieldLanguage()
    {
        $field = new Select('setting_language');
        $field->setLabel(T::_('language'));
        $field->setOptions(
            array_column(
                ModelLanguage::find([
                    'columns' => 'id,iso,title'
                ])->toArray(),
                'iso',
                'title'
            )
        );

        $this->addField($field);
    }
}