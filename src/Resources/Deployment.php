<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\K8sWorkloadResource;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

/**
 * Deployment is a good fit for managing a stateless application workload on
 * your cluster, where any Pod in the Deployment is interchangeable and can
 * be replaced if needed.
 */
final class Deployment extends K8sWorkloadResource
{
    use Exportable;

    /**
     * Deployment constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'Deployment', apiVersion: 'apps/v1');
    }

    /**
     * Return an array as a definition of the resource.
     *
     * @return array
     */
    public function toArray(): array
    {
        // TODO: Implement toArray() method.
        return [];
    }
}
