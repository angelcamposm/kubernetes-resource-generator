<?php

namespace Acamposm\KubernetesResourceGenerator;

abstract class K8sWorkloadResource extends K8sResource
{
    protected array $containers = [];
    protected array $initContainers = [];
    protected int $replicas;

    /**
     * K8sWorkloadResource constructor.
     *
     * @param string $kind
     * @param string $apiVersion
     */
    public function __construct(string $kind, string $apiVersion)
    {
        parent::__construct(kind: $kind, apiVersion: $apiVersion);
    }

    protected function checkContainers(): bool
    {
        return isset($this->containers) && !empty($this->containers);
    }

    protected function checkInitContainers(): bool
    {
        return isset($this->initContainers) && !empty($this->initContainers);
    }

    protected function checkReplicas(): bool
    {
        return isset($this->replicas) && !empty($this->replicas);
    }

    protected function getBaseArrayDefinition(): array
    {
        $resource = parent::getBaseArrayDefinition();

        if ($this->checkReplicas()) {
            $resource['spec']['replicas'] = $this->replicas;
        }

        return $resource;
    }
}
