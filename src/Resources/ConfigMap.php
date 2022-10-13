<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\K8sConfigurationResource;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

final class ConfigMap extends K8sConfigurationResource
{
    use Exportable;

    protected bool $inmutable = false;

    /**
     * ConfigMap constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'ConfigMap', apiVersion: 'v1');
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
