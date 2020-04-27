<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BidsValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $lastBid = $value->getLot()->getLastBid();

        if($lastBid) {
            if($value->getUser() == $lastBid->getUser()) {
                $this->context->buildViolation("La última puja es tuya")->addViolation();
            }
            if($value->getOffer() < $lastBid->getOffer()) {
                $this->context->buildViolation("La puja no puede ser menor que la anterior")->addViolation();
            }
        }
    }
}
