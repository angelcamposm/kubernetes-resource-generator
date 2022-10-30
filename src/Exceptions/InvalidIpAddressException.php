<?php

namespace Acamposm\KubernetesResourceGenerator\Exceptions;

use RuntimeException;

class InvalidIpAddressException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid IP Address.', 0);
    }
}
