<?php

namespace Lib\Validation\Validator;

use Phalcon\Exception;
use Phalcon\Text;
use Phalcon\Validation\Message;
use Phalcon\Validation;
use Lib\Validation\Validator;
use Phalcon\Validation\Validator\ExclusionIn;
use Phalcon\ValidationInterface;

class MyUniqueness extends Validator
{
    /** @var \Phalcon\Mvc\Model $model  */
    private $model;
    private $parentCheck;
    private $languageCheck;
    private $exclusionDomain;
    private $myValidation;
    private $parentField;
    private $languageField;
    private $inputtedMessage;

    public function __construct( array $options = null )
    {
        parent::__construct( $options );

        $this->model = $this->getOption('model');

        $this->parentCheck = $this->getOption('parentCheck', false);

        $this->languageCheck = $this->getOption('languageCheck', false);

        $this->parentField = $this->getOption('parent_field', 'parent_id');

        $this->languageField = $this->getOption('language_field', 'language_iso');

        $this->exclusionDomain = $this->getOption('exclusionDomain', []);

        $this->inputtedMessage = $this->getOption('message',null);

        $this->myValidation = new Validation();

    }

    /**
     * Executes the validation
     *
     * @param Validation $validation
     * @param string $fieldcheckParentName
     * @return bool
     * @throws Exception
     */
    public function validate(Validation $validation, $field)
    {
        if ($this->checkExclusionDomain($validation,$field))
            return true;

        if (!$this->checkNameNotEqualsParentName($validation, $field))
            return false;


        $this->myValidation->add(
            $field,
            new ExclusionIn(
                [
                    'domain' => $this->queryForFieldUniqueness($field),
                    'message' => 'This title is in the invalid domain',
                ]
            ));

        $validationMessages = $this->myValidation->validate(null, $this->model);

        if(is_bool($validationMessages))
            return true;

        if (!$this->inputtedMessage)
        {
            foreach ($validationMessages as $message)
            {
                $this->setErrorMessage($validation,$field,$message->getMessage());
            }
        }
        else
            $this->setErrorMessage($validation,$field,$this->inputtedMessage);


        return false;
    }

    /**
     * @param ValidationInterface $validation
     * @param $field
     * @param null $message
     */
    protected function setErrorMessage(Validation $validation, $field, $message = null)
    {
        $label = $this->prepareLabel($validation, $field);

        if(!$message)
            $message = $this->prepareMessage($validation, $field, "MyUniqueness");

        $code = $this->prepareCode($field);

        $replacePairs = [":field" => $label];

        $validation->appendMessage(
            new Message(
                strtr($message,$replacePairs),
                $field,
                "MyUniqueness",
                $code
            )
        );
    }

    protected function checkExclusionDomain(ValidationInterface $validation ,$field)
    {
        if (in_array($validation->getValue($field), $this->exclusionDomain))
            return true;

        return false;
    }

    /**
     * return array of titles whose parent and language are equal
     * we use it for title uniqueness validation
     * @example
     *  inputted language : 'fa'
     *  inputted parent_id : 1
     *      array(
     *              [0] => fa_title_1_1
     *              [1] => fa_title_1_2
     *              [2] => fa_title_1_3
     *          )
     * @param string $field
     * @return array
     */
    public function queryForFieldUniqueness($field)
    {
        $result = $this->model->getModelsManager()->createBuilder()
            ->columns([$field])
            ->from(get_class($this->model));

        if ($this->parentCheck())
        {
            $parentId =  $this->model->{$this->createMethodName($this->parentField)}();

            if ($parentId)
                $result->andWhere($this->parentField.' = :parentId:', ['parentId' => $parentId]);
            else
                $result->andWhere($this->parentField.' IS NULL');
        }
        if ($this->languageCheck())
        {
            $language = $this->model->{$this->createMethodName($this->languageField)}();

            $result->andWhere($this->languageField.'= :lang:', ['lang' => $language]);
        }
        return array_column($result->getQuery()->execute()->toArray(), $field);
    }

    /**
     * create standard method name
     * @example getParentId , getLanguageIso
     * @param $methodName
     * @return string
     */
    protected function createMethodName($methodName)
    {
        /** @var string $methodFullName */
        $methodFullName = 'get'.Text::camelize($methodName);

        return $methodFullName;
    }
    /**
     * compare value of inputted title with parent's title in the model.with same language
     * return false if they are equal.
     * @param Validation $validation
     * @param string $field
     * @return bool
     */
    public function checkNameNotEqualsParentName(Validation $validation, $field)
    {
        $parent = null;
        $language = null;

        if ($this->parentCheck && !method_exists($this->model, $this->createMethodName($this->parentField)))
        {
            $this->setErrorMessage(
                $validation,
                $field,
                "If parentCheck == true Why Method ({$this->createMethodName($this->parentField)}) does not exist in ". get_class($this->model)
            );
            return false;
        }

        if ($this->parentCheck())
            $parent = $this->model->{$this->createMethodName($this->parentField)}();

        if ($this->languageCheck && !method_exists($this->model, $this->createMethodName($this->languageField)))
        {
            $this->setErrorMessage(
                $validation,
                $field,
                "If languageCheck == true Why Method ({$this->createMethodName($this->languageField)}) does not exist in". get_class($this->model)
            );
            return false;
        }

        if ($this->languageCheck())
            $language = $this->model->{$this->createMethodName($this->languageField)}();

        if (!$language)
        {
            $this->setErrorMessage(
                $validation,
                $field,
                'If languageCheck == true Why value of language is empty'
            );
            return false;
        }

        if ($this->parentCheck && $this->checkParentName($validation,$field,$parent,$language))
        {
            $this->setErrorMessage(
                $validation,
                $field,
                'The value of this :field is the same as the value of his parent\'s :field'
            );
            return false;
        }

        return true;
    }

    /**
     * find parent's title (findFirst DB) and compare with value of field
     * if both of them are equal , return true.
     * @param \Phalcon\Validation $validation
     * @param $field
     * @param $parentId
     * @param $language
     * @return bool
     */
    protected function checkParentName(Validation $validation,$field,$parentId,$language)
    {
        $parent = $this->model->findFirst(
            [
                'columns' => $field,
                'conditions' => "id = ?1 AND {$this->languageField} = ?2",
                'bind' => [
                    1 => $parentId,
                    2 => $language,
                ],
            ]
        );

        $equal = $validation->getValue($field) == $parent->{$field};
        if ($equal)
            return true;

        return false;
    }

    /**
     * if parentCheck option is true & getParentId method is existed return true
     * @return bool
     */
    protected function parentCheck()
    {
        if($this->parentCheck && method_exists($this->model, $this->createMethodName($this->parentField)))
            return true;

        return false;
    }

    /**
     * if languageCheck option is true & getLanguageIso method is existed return true
     * @return bool
     */
    protected function languageCheck()
    {
        if($this->languageCheck && method_exists($this->model, $this->createMethodName($this->languageField)))
            return true;

        return false;
    }
}