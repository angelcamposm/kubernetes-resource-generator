<?php

namespace Acamposm\KubernetesResourceGenerator\Traits;

use Acamposm\KubernetesResourceGenerator\Helpers\Yaml;

trait Exportable
{
    /**
     * Dump the resource as Yaml.
     *
     * @return string
     */
    public function toYaml(): string
    {
        $resource = $this->toArray();

        //TODO: Add option to control if must be sorted by key.
        ksort($resource);

        $yaml = Yaml::dump($resource);

        $yaml = self::replaceCaretWithSingleQuote($yaml);

        $yaml = self::fixListItemsInNewLine($yaml);

        $searchString = ["/'\[/", "/]'/"];

        $replaceString = ['[', ']'];

        return preg_replace($searchString, $replaceString, $yaml);
    }

    /**
     * With some definition options, it's necessary to display between
     * single quotes.
     * A caret is inserted in the value assignment of the option, then
     * we replace caret with single quotes.
     *
     * @param string $yaml
     *
     * @return string
     */
    private static function replaceCaretWithSingleQuote(string $yaml): string
    {
        return str_replace('^', "'", $yaml);
    }

    /**
     * With Symfony::Yaml when an array is converted to yaml list, a new line
     * is inserted after a dash symbol.
     *
     * @param string $yaml
     *
     * @return string
     */
    private static function fixListItemsInNewLine(string $yaml): string
    {
        return preg_replace('/-\n\s+/', '- ', $yaml);
    }
}
