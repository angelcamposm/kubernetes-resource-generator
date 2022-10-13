<?php

namespace Acamposm\KubernetesResourceGenerator\Helpers;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class Yaml
{
    public const INDENT = 2;
    public const LEVEL = 6;

    public static function dump(mixed $input): string
    {
        return SymfonyYaml::dump(
            $input,
            self::LEVEL,
            self::INDENT,
            SymfonyYaml::DUMP_MULTI_LINE_LITERAL_BLOCK|SymfonyYaml::DUMP_OBJECT_AS_MAP|SymfonyYaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE
        );
    }
}
