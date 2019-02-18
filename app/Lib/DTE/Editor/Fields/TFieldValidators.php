<?php
namespace Lib\DTE\Editor\Fields;



use Phalcon\Validation\ValidatorInterface;

trait TFieldValidators
{
    /** @var ValidatorInterface[] */
    protected $validators = [];

    /**
     *
     * Returns the validators registered for the Field
     *
     * @return ValidatorInterface[]
     */
    public function getValidators()
    {
        return $this->validators;
    }

    public function addValidator(ValidatorInterface $validator)
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * Adds a group of validators
     *
     * @param ValidatorInterface[] $validators
     * @param boolean $merge
     * @return $this
     */
    public function addValidators(array $validators, $merge = true)
    {
        $mergeValidators = [];
		if ($merge)
		{
            $currentValidators = $this->validators;

            if(is_array($currentValidators))
            {
                $mergeValidators = array_merge($currentValidators, $validators);
            }
		}
		else
        {
            $mergeValidators = $validators;
        }

        $this->validators = $mergeValidators;

        return $this;
    }

}