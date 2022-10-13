<?php

namespace Acamposm\KubernetesResourceGenerator\Helpers;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class Yaml
{
    /**
     * The level where you switch to inline YAML.
     */
    public const INDENT = 2;

    /**
     * The amount of spaces to use for indentation of nested nodes.
     */
    public const LEVEL = 6;

    /**
     * A bit field of DUMP_* constants to customize the dumped YAML string.
     */
    public const FLAGS = SymfonyYaml::DUMP_MULTI_LINE_LITERAL_BLOCK
        | SymfonyYaml::DUMP_OBJECT_AS_MAP
        | SymfonyYaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE;

    public static function dump(mixed $input): string
    {
        return SymfonyYaml::dump($input,self::LEVEL,self::INDENT, self::FLAGS);
    }
}
