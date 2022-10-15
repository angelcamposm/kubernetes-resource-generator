<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\Enums\OperatingSystem;
use Acamposm\KubernetesResourceGenerator\Enums\RestartPolicy;
use Acamposm\KubernetesResourceGenerator\K8sWorkloadResource;
use Acamposm\KubernetesResourceGenerator\Traits\CanCheckProperties;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

final class Pod extends K8sWorkloadResource
{
    use Exportable, CanCheckProperties;

    private array $imagePullSecrets = [];
    private array $nameservers = [];
    private array $nodeSelectors = [];
    private array $options = [];
    private OperatingSystem $osName;
    private RestartPolicy $restartPolicy;
    private array $searches = [];
    private string $serviceAccount;

    /**
     * Pod constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'Pod', apiVersion: 'v1');
    }

    public function addContainers(array $containers): Pod
    {
        foreach($containers as $key => $value) {
            $this->containers[$key] = $value;
        }
        return $this;
    }

    /**
     * Allow a Pod to use a Secret to pull an image from a private container
     * image registry or repository.
     *
     * @param string $secretName
     *
     * @return $this
     */
    public function addImagePullSecret(string $secretName): Pod
    {
        $this->imagePullSecrets[] = ['name' => $secretName];
        return $this;
    }

    /**
     * Allow a Pod to use a Secret to pull an image from a private container
     * image registry or repository.
     *
     * @param string $secretName
     *
     * @return $this
     */
    public function addImagePullSecrets(array $secrets): Pod
    {
        foreach ($secrets as $key => $secret) {
            $this->imagePullSecrets[] = ['name' => $secret];
        }
        return $this;
    }

    public function addNodeSelectors(array $selectors): Pod
    {
        foreach ($selectors as $key => $value) {
            $this->nodeSelectors[$key] = $value;
        }
        return $this;
    }

    /**
     * Set the Operating System name.
     * It can be one of linux|windows.
     *
     * @param OperatingSystem $name
     *
     * @return Pod
     */
    public function osName(OperatingSystem $name): Pod
    {
        $this->osName = $name;
        return $this;
    }

    /**
     * The restartPolicy applies to all containers in the Pod. restartPolicy
     * only refers to restarts of the containers by the kubelet on the same
     * node.
     *
     * @param RestartPolicy $policy
     *
     * @return Pod
     */
    public function restartPolicy(RestartPolicy $policy): Pod
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

    /**
     * Return an array as a definition of the resource.
     *
     * @return array
     */
    public function toArray(): array
    {
        $resource = $this->getBaseArrayDefinition();

        if ($this->checkProperty('osName')) {
            $resource['spec']['os']['name'] = $this->osName->value;
        }

        if ($this->checkProperty('initContainers')) {
            $resource['spec']['initContainers'] = $this->initContainers;
        }

        if ($this->checkProperty('containers')) {
            $resource['spec']['containers'] = $this->containers;
        }

        if ($this->checkProperty('imagePullSecrets')) {
            $resource['spec']['imagePullSecrets'] = $this->imagePullSecrets;
        }

        if ($this->checkProperty('nodeSelectors')) {
            $resource['spec']['nodeSelector'] = $this->nodeSelectors;
        }

        if ($this->checkProperty('restartPolicy')) {
            $resource['spec']['restartPolicy'] = $this->restartPolicy->value;
        }

        if ($this->checkProperty('serviceAccount')) {
            $resource['spec']['serviceAccount'] = $this->serviceAccount;
        }

        return $resource;
    }
}
