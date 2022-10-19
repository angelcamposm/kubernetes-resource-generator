<?php

namespace Acamposm\KubernetesResourceGenerator\Exceptions;

use RuntimeException;

class PortNumberException extends RuntimeException
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        parent::__construct($string);
    }
}
