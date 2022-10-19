<?php

namespace Acamposm\KubernetesResourceGenerator\Exceptions;

use RuntimeException;

class NegativeIntegerNotAllowedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Value must be non-negative integer.', 0);
    }
}
