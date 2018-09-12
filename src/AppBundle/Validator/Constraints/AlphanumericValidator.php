<?php

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class AlphanumericValidator
 * @package AppBundle\Validator\Constraints
 */
class AlphanumericValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ( ! $constraint instanceof Alphanumeric) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\Alphanumeric');
        }

        if (null === $value || '' === $value) {
            return;
        }

        if ( ! preg_match('/^[a-zA-Z0-9 ]+$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                          ->setParameter('{{ attribute }}', $constraint->attribute)
                          ->addViolation();
        }
    }
}