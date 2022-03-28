<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DomainValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var Domain $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if (in_array($value, $constraint->domain)) {
          // TODO: implement the validation here
          $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
        }
    }
}
