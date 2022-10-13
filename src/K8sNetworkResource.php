<?php

namespace Acamposm\KubernetesResourceGenerator;

abstract class K8sNetworkResource extends K8sResource
{
    public function __construct(string $kind, string $apiVersion)
    {
        parent::__construct(kind: $kind, apiVersion: $apiVersion);
    }
}
