<?php

namespace Acamposm\KubernetesResourceGenerator;

use Acamposm\KubernetesResourceGenerator\Traits\CanCheckProperties;

abstract class K8sWorkloadResource extends K8sResource
{
    use CanCheckProperties;

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

    /**
     * Add containers to a workload resource.
     *
     * @param array $containers
     *
     * @return K8sWorkloadResource
     */
    public function addContainers(array $containers): K8sWorkloadResource
    {
        foreach ($containers as $key => $value) {
            $this->containers[$key] = $value;
        }
        return $this;
    }

    /**
     * Set replicas.
     *
     * @param int $replicas
     *
     * @return K8sWorkloadResource
     */
    public function replicas(int $replicas): K8sWorkloadResource
    {
        $this->replicas = $replicas;
        return $this;
    }

    protected function getBaseArrayDefinition(): array
    {
        $resource = parent::getBaseArrayDefinition();

        if ($this->checkProperty('replicas')) {
            $resource['spec']['replicas'] = $this->replicas;
        }

        return $resource;
    }
}
