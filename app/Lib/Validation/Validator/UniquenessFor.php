<?php
namespace Lib\Validation\Validator;


use Lib\Validation\Validator;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Text;
use Phalcon\Validation;
use Phalcon\Validation\Message;

class UniquenessFor extends Validator
{

    /**
     * Executes the validation
     *
     * @param \Phalcon\Validation $validation
     * @param string $field
     * @return bool
     */
    public function validate(Validation $validation, $field): bool
    {
        $label = $this->getOption('label');
        $message = $this->getOption('message');
        $fields = $this->getOption('fields');

        if (empty($label))
        {
            $label = $validation->getLabel($field);
        }

        if (!$this->isUniqueness($validation, $field, $fields, $label))
        {
            if (empty($message))
            {
                $message = $validation->getDefaultMessage('UniquenessFor');
            }

            $this->setMessage($validation, strtr($message, [":field" => $field, ":fields" => join(',', $fields)]), $field, $label);

            return false;
        }

        return true;
    }

    protected function isUniqueness(Validation $validation, $field, $fields, $label): bool
    {
        if (!is_string($field))
        {
            $this->setMessage($validation, "Field :field must be string format", $field, $label);
            return false;
        }

        if (empty($fields))
        {
            $this->setMessage($validation, "Please insert fields option in array format", $field, $label);
            return false;
        }

        /** @var ModelInterface $model */
        $model = $this->getOption('model');

        if (!$model instanceof ModelInterface)
        {
            $this->setMessage(
                $validation,
                "model option must be instance of ModelInterface",
                $field,
                $label
            );
            return false;
        }

        $params = [];
        $params['conditions'] = "$field=:$field: ";
        $params['bind'][$field] = $model->{'get'. Text::camelize($field, '_-')}();

        foreach ($fields as $f)
        {
            $params['conditions'] .= "AND $f=:$f: ";
            $params['bind'][$f] = $model->{'get'. Text::camelize($f, '_-')}();
        }

        $count = count(
            get_class($model)::find($params)->toArray()
        );

        if ($count > 1)
        {
            return false;
        }

        return true;
    }

    protected function setMessage(Validation $validation, string $message, $field, $label)
    {
        $validation->appendMessage(
            new Message(
                new Message(
                    $message,
                    [
                        ':field' => $label
                    ]
                ),
                $field,
                "UniquenessFor", $this->getOption('code')
            )
        );
    }
}