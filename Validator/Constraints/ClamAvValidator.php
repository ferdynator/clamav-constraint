<?php

namespace ferdynator\ClamAvConstraint\Validator\Constraints;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xenolope\Quahog\Client;
use Socket\Raw\Factory;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class ClamAvValidator
 *
 * @package ferdynator\ClamAvConstraint\Validator\Constraints
 */
class ClamAvValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ClamAv) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\ClamAv');
        }

        $socket = (new Factory())->createClient($constraint->socket);
        $client = new Client($socket, 1, PHP_NORMAL_READ);
        $client->startSession();

        if (null === $value || '' === $value || !$client->ping()) {
            return;
        }

        $path = $value instanceof File ? $value->getPathname() : (string) $value;

        @chmod($path, $constraint->chmod);

        $scanResult = $client->scanFile($path);
        if ($scanResult['status'] !== Client::RESULT_OK) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{reason}}', $scanResult['reason'])
                ->addViolation();
        }

        $client->endSession();
    }
}