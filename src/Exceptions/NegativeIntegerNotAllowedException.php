<?php

namespace Acamposm\KubernetesResourceGenerator\Exceptions;

use RuntimeException;

class NegativeIntegerNotAllowedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('The value must not be an integer of negative value.', 0);
    }
}
