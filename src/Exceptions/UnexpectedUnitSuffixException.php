<?php

namespace Acamposm\KubernetesResourceGenerator\Exceptions;

use RuntimeException;

class UnexpectedUnitSuffixException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct('Unknown unit suffix: '.$message, 0);
    }
}