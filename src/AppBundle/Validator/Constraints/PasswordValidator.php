<?php

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class PasswordValidator
 * @package AppBundle\Validator\Constraints
 */
class PasswordValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ( ! $constraint instanceof Password) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\Password');
        }

        if (null === $value || '' === $value) {
            return;
        }

        if ( ! preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}$/', $value)) {
            $this->context->buildViolation($constraint->message)
                          ->addViolation();
        }
    }
}