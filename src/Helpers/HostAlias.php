<?php

namespace Acamposm\KubernetesResourceGenerator\Helpers;

use Acamposm\KubernetesResourceGenerator\Exceptions\InvalidIpAddressException;

class HostAlias
{
    public static function get(string $host, string $ip): array
    {
        if (false === filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new InvalidIpAddressException();
        }

        return [
            'host' => $host,
            'ip' => $ip
        ];
    }
}
