<?php

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class Alphanumeric
 * @package AppBundle\Validator\Constraints
 * @Annotation
 */
class Alphanumeric extends Constraint
{
    public $message = 'The {{ attribute }} only contain letters or numbers.';
    public $attribute = 'attribute';

}