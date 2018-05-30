<?php

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Cif extends Constraint
{
    public $message = 'El cif introducido no es válido.';
}