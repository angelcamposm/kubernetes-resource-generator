<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\K8sWorkloadResource;
use Acamposm\KubernetesResourceGenerator\Traits\CanCheckProperties;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

/**
 * A ReplicaSet's purpose is to maintain a stable set of replica Pods running
 * at any given time. As such, it is often used to guarantee the availability
 * of a specified number of identical Pods.
 */
final class ReplicaSet extends K8sWorkloadResource
{
    use CanCheckProperties, Exportable;

    private array $podSelectors = [];
    private array $templateLabels = [];

    /**
     * ReplicaSet constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'ReplicaSet', apiVersion: 'apps/v1');
    }

    public function addContainers(array $containers): ReplicaSet
    {
        foreach ($containers as $container) {
            $this->containers[] = $container;
        }
        return $this;
    }

    public function addPodSelectors(array $podSelectors): ReplicaSet
    {
        foreach ($podSelectors as $key => $value) {
            $this->podSelectors[$key] = $value;
        }
        return $this;
    }

    public function addTemplateLabels(array $labels): ReplicaSet
    {
        foreach ($labels as $key => $value) {
            $this->templateLabels[$key] = $value;
        }
        return $this;
    }

    /**
     * Return an array as a definition of the resource.
     *
     * @return array
     */
    public function toArray(): array
    {
        $resource = $this->getBaseArrayDefinition();

        if ($this->checkProperty('podSelectors')) {
            $resource['spec']['selector']['matchLabels'] = $this->podSelectors;
        }

        if ($this->checkProperty('templateLabels')) {
            $resource['spec']['template']['metadata']['labels'] = $this->templateLabels;
        }

        if ($this->checkProperty('containers')) {
            $resource['spec']['template']['spec']['containers'] = $this->containers;
        }

        // Set default Restart Policy
        $resource['spec']['template']['spec']['restartPolicy'] = 'Always';

        return $resource;
    }
}
