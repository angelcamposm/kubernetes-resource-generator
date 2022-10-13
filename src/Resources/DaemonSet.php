<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\K8sWorkloadResource;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

/**
 * A DaemonSet ensures that all (or some) Nodes run a copy of a Pod. As nodes
 * are added to the cluster, Pods are added to them. As nodes are removed from
 * the cluster, those Pods are garbage collected. Deleting a DaemonSet will
 * clean up the Pods it created.
 */
final class DaemonSet extends K8sWorkloadResource
{
    use Exportable;

    /**
     * DaemonSet constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'DaemonSet', apiVersion: 'apps/v1');
    }

    /**
     * Return an array as a definition of the resource.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->getBaseArrayDefinition();
    }
}
