<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\K8sNetworkResource;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

/**
 * An abstract way to expose an application running on a set of Pods as a
 * network service.
 * With Kubernetes, you don't need to modify your application to use an
 * unfamiliar service discovery mechanism. Kubernetes gives Pods their own
 * IP addresses and a single DNS name for a set of Pods, and can load-balance
 * across them.
 */
final class Service extends K8sNetworkResource
{
    use Exportable;

    protected array $ports = [];
    
    /**
     * Service Constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'Service', apiVersion: 'v1');
    }

    public function addPort(
        int $exposedPort,
        int $targetPort,
        string|null $name = null,
        string $protocol = 'TCP'
    ): Service
    {
        $port = [
            'port' => $exposedPort,
            'protocol' => $protocol,
            'targetPort' => $targetPort,
        ];

        if ($name !== null) {
            $port['name'] = $name;
        }

        $this->ports[] = $port;
        return $this;
    }

    public function toArray(): array
    {
        $resource = $this->getBaseArrayDefinition();

        if (isset($this->selectors) && !empty($this->selectors)) {
            $resource['spec']['selectors'] = $this->selectors;
        }

        if (isset($this->ports) && !empty($this->ports)) {
            $resource['spec']['ports'] = $this->ports;
        }

        return $resource;
    }
}
