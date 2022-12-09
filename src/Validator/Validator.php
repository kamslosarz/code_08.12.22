<?php

namespace App\Validator;

use App\Validator\Constraint\ConstraintInterface;

class Validator
{
    /**
     * @var ConstraintInterface[];
     */
    protected array $constraints;

    public function addConstraint(ConstraintInterface $constraint): void
    {
        $this->constraints[] = $constraint;
    }

    /**
     * @param $value
     * @return void
     * @throws Constraint\ConstraintException
     */
    public function validate($value): void
    {
        foreach ($this->constraints as $constraint) {

            $constraint->validate($value);
        }
    }
}
