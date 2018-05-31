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

    private function validarFomatoCif($cif)
    {
        $resultado = false;

        if (1 === preg_match("/^([ABCDEFGHJKLMNPQRSUVW]{1})(\d{7})([0-9A-J]{1})$/", $cif)) {
            $resultado = $this->comprobarCaracterControl($cif);
        }

        return $resultado;

        //return 1 === preg_match("/^([ABCDEFGHJKLMNPQRSUVW]{1})(\d{7})([0-9A-J]{1})$/", $cif);

    }

    private function comprobarCaracterControl($cif)
    {
        $cadenaControl = 'JABCDEFGHI';
        $caracter = substr($cif, 8, 1);
        $n = $this->calcularModulo($cif);
        $control = substr($cadenaControl, $n, 1);
        $coincide = false;

        switch (true) {
            case (1 === preg_match("/^([NPQSW])$/", $cif) || (substr($cif, 1, 1)) == 0 && substr($cif, 2, 1) == 0):
                // $caracter tiene que ser una letra y corresponderse con la de la posición obtenida en el cálculo del módulo
                if ($caracter === $control) {
                    $coincide = true;
                }
                break;
            case (1 === preg_match("/^([ABEH])$/", $cif)):
                // Si empieza por ABEH tiene que ser un número y corresponderse con el obtenido en el cálculo del módulo
                if ($caracter == $n) {
                    $coincide = true;
                }
                break;
            default:
                // En cualquier otro caso, puede ser un número o una letra, pero corresponderse con el control o con n
                if ($caracter == $control || $caracter == $n) {
                    $coincide = true;
                }

        }

        return $coincide;
    }

    private function calcularModulo($cif)
    {
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
        return $modulo;
    }
}