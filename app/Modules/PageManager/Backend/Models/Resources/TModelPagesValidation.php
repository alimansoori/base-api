<?php
namespace Modules\PageManager\Backend\Models\Resources;


use Lib\Translate\T;
use Lib\Validation;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\PageManager\Models\Routes\ModelRoutes;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength;

/**
 * @property Validation $validator
 */
trait TModelPagesValidation
{
    public function mainValidation()
    {
        $this->validateTitle();
        $this->validateTitleMenu();
        $this->validateKeywords();
        $this->validateDescription();
        $this->validateSlug();
        $this->validateContent();
    }

    private function validateTitle()
    {
        $this->validator->add(
            'title',
            new StringLength([
                'min' => 2,
                'max' => 70,
                'label' => T::_('title')
            ])
        );
    }

    private function validateTitleMenu()
    {
        $this->validator->add(
            'title_menu',
            new StringLength([
                'min' => 5,
                'max' => 20,
                'label' => T::_('page_title_in_menu'),
                'allowEmpty' => true
            ])
        );
    }

    private function validateKeywords()
    {
        $this->validator->add(
            'keywords',
            new StringLength([
                'max' => 255,
                'label' => T::_('page_keywords'),
                'allowEmpty' => true
            ])
        );
    }
    private function validateDescription()
    {
        $this->validator->add(
            'description',
            new StringLength([
                'max' => 255,
                'label' => T::_('page_description'),
                'allowEmpty' => true
            ])
        );
    }
    private function validateSlug()
    {
        if($this->isModeUpdate())
        {
            /** @var self $page */
            $page = self::findFirst($this->getId());
            if(!$page)
                return false;

            if($page->getSlug() != $this->getSlug())
            {
                $this->validator->add(
                    'slug',
                    new Validation\Validator\MyUniqueness([
                        'model' => $this,
                        'languageCheck' => true
                    ])
                );
            }
        }
        elseif($this->isModeCreate())
        {
            $this->validator->add(
                'slug',
                new Validation\Validator\MyUniqueness([
                    'model' => $this,
                    'languageCheck' => true
                ])
            );
        }
    }

    private function validateContent()
    {
        $this->validator->add(
            'content',
            new StringLength([
                'max' => 800,
                'label' => T::_('page_content'),
                'allowEmpty' => true
            ])
        );
    }
}