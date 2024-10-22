<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute()]
class OwnedArtist extends Constraint
{
    public function validate(mixed $value, Constraint $constraint): void
    {}
}