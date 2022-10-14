<?php

namespace Acamposm\KubernetesResourceGenerator\Exceptions;

use RuntimeException;

class UnexpectedUnitSuffixException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Unknown unit suffix.', 0);
    }
}