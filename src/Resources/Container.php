<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

class Container
{
    use Exportable;

    public array $command = [];
    public array $environment = [];
    public string $image;
    public string $name;
    public array $volumeMounts = [];
}
