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
        $yaml = Yaml::dump($this->toArray());

        $searchString = ['/-\n\s+/', "/'\[/", "/]'/"];

        $replaceString = ['- ', '[', ']'];

        return preg_replace($searchString, $replaceString, $yaml);
    }
}
