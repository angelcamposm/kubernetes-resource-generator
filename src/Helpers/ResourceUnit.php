<?php

namespace Acamposm\KubernetesResourceGenerator\Helpers;

use Acamposm\KubernetesResourceGenerator\Exceptions\UnexpectedUnitSuffixException;
use Exception;

class ResourceUnit
{
    public const UNIT_SUFFIXES = ['E', 'P', 'T', 'G', 'M', 'k', 'Ei', 'Pi', 'Ti', 'Gi', 'Mi', 'Ki', 'm'];

    public static function validate(mixed $value): string
    {
        if (is_int(filter_var($value, FILTER_VALIDATE_INT))) {
            return $value;
        }

        return self::validateString($value);
    }

    /**
     * @throws Exception
     */
    private static function validateString(string $value): string
    {
        $intValue = filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        $suffixValue = str_replace($intValue, '', $value);

        if (!in_array($suffixValue, self::UNIT_SUFFIXES)) {
            throw new UnexpectedUnitSuffixException($suffixValue);
        }

        return $value;
    }
}