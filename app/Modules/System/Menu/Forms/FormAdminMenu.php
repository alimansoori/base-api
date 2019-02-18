<?php
namespace Modules\System\Menu\Forms;


use Lib\Common\Arrays;
use Lib\DTE\RequestTypes;
use Lib\Forms\Element\Hidden;
use Lib\Forms\Element\Numeric;
use Lib\Forms\Element\Select;
use Lib\Forms\Element\Select2;
use Lib\Forms\Element\Text;
use Lib\Forms\Element\TextArea;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class FormAdminMenu extends Form
{
    public function initialize()
    {
        $this->elmTitle();
        $this->elmParent();
        $this->elmDescription();
        $this->elmCategory();
        $this->elmLink();
        $this->elmIcon();
        $this->elmPosition();
        $this->elmCsrf();

    }

    private function elmTitle()
    {
        $title = new Text('title');
        $title->setLabel('Title');
        $title->addValidators([
            new PresenceOf([
                'message' => ':field is required',
                'cancelOnFail' => true
            ]),
            new StringLength([
                'min' => 3,
                'max' => 20,
                'messageMinimum' => ':field is small',
                'messageMaximum' => ':field is big length'
            ])
        ]);

        $this->add($title);
    }

    private function elmParent()
    {
        // to multi level
        $adminMenu = Arrays::treeFlat(
            ModelAdminMenu::find([
                'columns' => 'id, title, parent_id'
            ])->toArray()
        );

        $row = [
            [
                'id' => null,
                'title' => 'Top level'
            ]
        ];
        foreach($adminMenu as $menu)
        {
            $menu['title'] = str_repeat('> ', $menu['level']). $menu['title'];
            $row[] = $menu;
        }


        $parent = new Select2('parent_id');
        $parent->setLabel('Parent');
        $parent->setOptions(
            array_column(
                $row,
                'title', 'id')
        );

        $parent->addValidators([
            new InclusionIn([
                    'domain' => array_merge(
                        [null],
                        array_column(
                            ModelAdminMenu::find([
                                'columns' => 'id',
                            ])->toArray(),
                            'id'
                        )
                    ),
                    'message' => 'form => not range parent id',
                    'allowEmpty' => true
                ])
        ]);

//        $parent->opts->setPlaceholder("Please select parent");


        $this->add($parent);
    }

    private function elmDescription()
    {
        $description = new TextArea('description');
        $description->setLabel('Description');
        $description->addValidator(
            new StringLength([
                'max' => 200,
                'messageMaximum' => 'form => :field is big',
                'allowEmpty' => true
            ])
        );
        $this->add($description);
    }

    private function elmCategory()
    {
        $category = new Select('manage');
        $category->setLabel('Category');
        $category->setOptions(ModelAdminMenuCategory::getColumnsIDToTitle());
        $category->addValidator(
            new InclusionIn([
                'domain' => ModelAdminMenuCategory::getColumnsID(),
                'message' => 'form => :field does not in range'
            ])
        );
        $this->add($category);
    }

    private function elmLink()
    {
        $link = new Text('link');
        $link->setLabel('Link');
        $link->addValidator(
            new StringLength([
                'max' => 200,
                'messageMaximum' => 'form => :field is big',
                'allowEmpty' => true
            ])
        );

        $this->add($link);
    }

    private function elmIcon()
    {
        $icon = new Select2('icon');
        $icon->setLabel('Icon');
        $icon->opts->setPlaceholder("Please enter icon name");
        $icon->opts->ajax->setUrl('/cms/assets/fontawesome/fontawesome.json');
        $icon->opts->ajax->setDataSrc('json');
        //        $icon->opts->ajax->setProcessResults("function (data) { return {results: data};}");
        $icon->opts->ajax->setProcessResults("function (data, params) {	var resData = []; data.forEach(function(value) { if (value.text.indexOf(params.term) != -1) resData.push(value) }); return { results: $.map(resData, function(item) { return { text: item.text, id: item.id } }) }; }");
        $icon->opts->setTemplateResult("function (option) { return '<i class=\"'+option.id+'\"></i>  ' + option.text;}");
        $icon->opts->setTemplateSelection("function (option) { return '<i class=\"'+option.id+'\"></i>  ' + option.text;}");
        $icon->opts->setEscapeMarkup("function (m) { return m;}");

        $icon->addValidator(
            new StringLength([
                'max' => 50,
                'messageMaximum' => 'form => :field is big',
                'allowEmpty' => true
            ])
        );
        //        dump($icon->getOpts());
        $this->add($icon);
    }

    private function elmPosition()
    {
        $position = new Text('position');
        $position->setLabel('Position');

        $position->addValidator(
            new Numericality([
                'message' => 'form => :field does not numeric',
                'allowEmpty' => true
            ])
        );

        $this->add($position);
    }

    private function elmCsrf()
    {
        $csrf = new Hidden('csrf', [
            'value' => $this->getCsrf()
        ]);
        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => ':field validation failed'
        ]));

        $this->add($csrf);
    }

    public function getCsrf()
    {
        if(!$this->security->getSessionToken())
            return $this->security->getToken();
        else
            return $this->security->getSessionToken();
    }
}