<?php

namespace MadeITBelgium\Versio\Validation;

class ValidatorExtensions
{
    /**
     * @var MadeITBelgium\Versio\Validation\Validator
     */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function validatedomainvailable($attribute, $value)
    {
        return $this->validator->isDomainAvailable($value);
    }
}
