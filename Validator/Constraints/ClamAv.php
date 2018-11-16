<?php

namespace ferdynator\ClamAvConstraint\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class ClamAvValidator
 *
 * @Annotation
 * @package ferdynator\ClamAvConstraint\Validator\Constraints
 */
class ClamAv extends Constraint
{
    public $message = "The file did not pass the virus scanner: {{reason}}";

    public $socket = "unix:///var/run/clamav/clamd.ctl";
}
