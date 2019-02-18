<?php
namespace Modules\System\Users\Editor\FurtherInformation;


use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Translate\T;

trait TFields
{
    protected function fieldProfileUrl()
    {
        $field = new Text('profile_url');
        $field->setLabel(T::_('profile_url'));

        $this->addField($field);
    }

    protected function fieldBlogAddress()
    {
        $field = new Text('blog_address');
        $field->setLabel(T::_('blog_address'));

        $this->addField($field);
    }

    protected function fieldSignature()
    {
        $field = new Text('signature');
        $field->setLabel(T::_('signature'));

        $this->addField($field);
    }

    protected function fieldFavorites()
    {
        $field = new Text('favorites');
        $field->setLabel(T::_('favorites'));

        $this->addField($field);
    }

    protected function fieldAvatarAddress()
    {
        $field = new Text('avatar_address');
        $field->setLabel(T::_('avatar_address'));

        $this->addField($field);
    }

    protected function fieldDescription()
    {
        $field = new Text('description');
        $field->setLabel(T::_('description'));

        $this->addField($field);
    }
}