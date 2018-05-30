<?php

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CifValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        $cif = strtoupper($value);

        if (!$this->validarFomatoCif($cif)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

    }

    public function validarFomatoCif($cif)
    {
        //$resultado = false;

        //if (1 === preg_match("/^([ABCDEFGHJKLMNPQRSUVW]{1})(\d{7})([0-9A-J]{1})$/", $cif)) {

        //}

        //return $resultado;

        return 1 === preg_match("/^([ABCDEFGHJKLMNPQRSUVW]{1})(\d{7})([0-9A-J]{1})$/", $cif);

    }

    private function calcularModulo($cif)
    {
        $arrayControl = 'JABCDEFGHI';
        $par = 0;
        $impar = 0;
        $sumatoria = 0;

        for ($i = 2; $i <= 6; $i += 2) {
            $par += (int)substr($cif, $i, 1);
        }

        for ($i = 1; $i <= 7; $i += 2) {
            $sumatoria = 2*(int)substr($cif, $i, 1);
            if ($sumatoria > 9) {
                $impar += 1 + ($sumatoria - 10);
            } else {
                $impar += $sumatoria;
            }
        }
        $modulo = ($par + $impar) % 10;
        if ($modulo != 0) {
            $modulo = 10 - $modulo;
        }
        return array("$modulo", substr($arrayControl, $modulo, 1));
    }
}