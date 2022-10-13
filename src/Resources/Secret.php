<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\K8sConfigurationResource;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

final class Secret extends K8sConfigurationResource
{
    use Exportable;

    /**
     * ConfigMap constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'Secret', apiVersion: 'v1');
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        // TODO: Implement toArray() method.
        return [];
    }
}
