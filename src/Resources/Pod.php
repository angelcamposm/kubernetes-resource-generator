<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\K8sWorkloadResource;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

final class Pod extends K8sWorkloadResource
{
    use Exportable;

    // OS name
    public const OS_LINUX = 'linux';
    public const OS_WINDOWS = 'windows';
    // Restart Policies
    public const RP_ALWAYS = 'Always';
    public const RP_ON_FAILURE = 'OnFailure';
    public const RP_NEVER = 'Never';

    private array $nameservers = [];
    private array $options = [];
    private string $osName;
    private string $restartPolicy;
    private array $searches = [];
    private string $serviceAccount;

    /**
     * Pod constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'Pod', apiVersion: 'v1');
    }

    public function osName(string $name): Pod
    {
        $this->osName = $name;
        return $this;
    }

    public function replicas(int $replicas): Pod
    {
        $this->replicas = $replicas;
        return $this;
    }

    /**
     * The restartPolicy applies to all containers in the Pod. restartPolicy
     * only refers to restarts of the containers by the kubelet on the same
     * node.
     *
     * @param string $policy
     *
     * @return $this
     */
    public function restartPolicy(string $policy): Pod
    {
        $this->restartPolicy = $policy;
        return $this;
    }

    /**
     * the name of the pod's service account.
     *
     * @param string $serviceAccount
     *
     * @return Pod
     */
    public function serviceAccount(string $serviceAccount): Pod
    {
        $this->serviceAccount = $serviceAccount;
        return $this;
    }

    protected function checkOsName(): bool
    {
        return isset($this->osName) && !empty($this->osName);
    }

    protected function checkRestartPolicy(): bool
    {
        return isset($this->restartPolicy) && !empty($this->restartPolicy);
    }

    protected function checkServiceAccount(): bool
    {
        return isset($this->serviceAccount) && !empty($this->serviceAccount);
    }

    /**
     * Return an array as a definition of the resource.
     *
     * @return array
     */
    public function toArray(): array
    {
        $resource = $this->getBaseArrayDefinition();

        if ($this->checkOsName()) {
            $resource['spec']['os']['name'] = $this->osName;
        }

        if ($this->checkInitContainers()) {
            $resource['spec']['initContainers'] = $this->initContainers;
        }

        if ($this->checkContainers()) {
            $resource['spec']['containers'] = $this->containers;
        }

        if ($this->checkRestartPolicy()) {
            $resource['spec']['restartPolicy'] = $this->restartPolicy;
        }

        if ($this->checkServiceAccount()) {
            $resource['spec']['serviceAccount'] = $this->serviceAccount;
        }

        return $resource;
    }
}