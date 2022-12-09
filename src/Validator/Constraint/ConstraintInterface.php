<?php

namespace App\Validator\Constraint;

interface ConstraintInterface
{
    /**
     * @param $value
     * @throws ConstraintException
     */
    public function validate($value): void;
}
