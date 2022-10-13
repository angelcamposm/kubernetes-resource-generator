<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\K8sNetworkResource;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

/**
 * Ingress exposes HTTP and HTTPS routes from outside the cluster to services
 * within the cluster. Traffic routing is controlled by rules defined on the
 * Ingress resource.
 * Ingress may provide load balancing, SSL termination and name-based virtual
 * hosting.
 */
final class Ingress extends K8sNetworkResource
{
    use Exportable;

    /**
     * Ingress constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'Ingress', apiVersion: 'networking.k8s.io/v1');
    }

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
        return [];
    }
}
