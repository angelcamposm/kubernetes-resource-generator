<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\K8sResource;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

/**
 * StatefulSet is the workload API object used to manage stateful applications.
 * Manages the deployment and scaling of a set of Pods, and provides guarantees
 * about the ordering and uniqueness of these Pods.
 *
 * Like a Deployment, a StatefulSet manages Pods that are based on an identical
 * container spec. Unlike a Deployment, a StatefulSet maintains a sticky identity
 * for each of their Pods. These pods are created from the same spec, but are not
 * interchangeable: each has a persistent identifier that it maintains across
 * any rescheduling.
 */
final class StatefulSet extends K8sResource
{
    use Exportable;

    /**
     * StatefulSet constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'StatefulSet', apiVersion: 'apps/v1');
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
