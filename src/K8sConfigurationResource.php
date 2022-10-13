<?php

namespace Acamposm\KubernetesResourceGenerator;

abstract class K8sConfigurationResource extends K8sResource
{
    protected array $data = [];

    /**
     * @inheritDoc
     */
    abstract public function toArray(): array;
}