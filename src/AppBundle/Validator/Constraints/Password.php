<?php

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class Password
 * @package AppBundle\Validator\Constraints
 * @Annotation
 */
class Password extends Constraint
{
    public $message = 'This value format is invalid.';

}