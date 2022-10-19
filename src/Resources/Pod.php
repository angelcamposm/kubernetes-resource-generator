<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\Enums\DnsPolicy;
use Acamposm\KubernetesResourceGenerator\Enums\OperatingSystem;
use Acamposm\KubernetesResourceGenerator\Enums\RestartPolicy;
use Acamposm\KubernetesResourceGenerator\Exceptions\NegativeIntegerNotAllowedException;
use Acamposm\KubernetesResourceGenerator\K8sWorkloadResource;
use Acamposm\KubernetesResourceGenerator\Traits\CanCheckProperties;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

final class Pod extends K8sWorkloadResource
{
    use Exportable, CanCheckProperties;

    private array $resource;

    private int $activeDeadlineSeconds;
    private bool $automountServiceAccountToken;
    protected array $containers = [];
    private array $dnsConfigNameservers = [];
    private array $dnsConfigOptions = [];
    private array $dnsConfigSearches = [];
    private string $dnsPolicy;
    private array $hostAlias = [];
    private string $hostname;
    private array $imagePullSecrets = [];
    protected array $initContainers = [];
    private array $nameservers = [];
    private array $nodeSelectors = [];
    private array $options = [];
    private string $osName;
    private string $restartPolicy;
    private array $searches = [];
    private string $serviceAccount;
    private string $subdomain;
    private int $terminationGracePeriodSeconds;

    /**
     * Pod constructor.
     */
    public function __construct()
    {
        parent::__construct(kind: 'Pod', apiVersion: 'v1');
    }

    /**
     * Optional duration in seconds the pod may be active on the node relative
     * to StartTime before the system will actively try to mark it failed and
     * kill associated containers.
     *
     * @param int $seconds
     *
     * @return Pod
     */
    public function activeDeadlineSeconds(int $seconds): Pod
    {
        self::checkNegativeValue($seconds);

        $this->activeDeadlineSeconds = $seconds;
        return $this;
    }

    /**
     * Add a container to Pod template.
     *
     * @param array $container
     *
     * @return Pod
     */
    public function addContainer(array $container): Pod
    {
        $this->containers[] = $container;
        return $this;
    }

    /**
     * Add containers to Pod template.
     *
     * @param array $containers
     *
     * @return Pod
     */
    public function addContainers(array $containers): Pod
    {
        foreach ($containers as $key => $value) {
            $this->containers[$key] = $value;
        }
        return $this;
    }

    /**
     * Add init containers to Pod template.
     *
     * @param array $containers
     *
     * @return Pod
     */
    public function addInitContainers(array $containers): Pod
    {
        foreach ($containers as $key => $value) {
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
     * @param array $secrets
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

    /**
     * AutomountServiceAccountToken indicates whether a service account token
     * should be automatically mounted.
     *
     * @return Pod
     */
    public function automountServiceAccountToken(): Pod
    {
        $this->automountServiceAccountToken = true;
        return $this;
    }

    public function nodeSelectors(array $selectors): Pod
    {
        foreach ($selectors as $key => $value) {
            $this->nodeSelectors[$key] = $value;
        }
        return $this;
    }

    public function dnsPolicy(DnsPolicy $policy): Pod
    {
        $this->dnsPolicy = $policy->value;
        return $this;
    }

    /**
     * HostAlias holds the mapping between IP and hostnames that will be
     * injected as an entry in the pod's hosts file.
     *
     * @example [['host' => 'dns1', 'ip' => '127.0.0.1']]
     * @param array $hostAliases
     *
     * @return Pod
     */
    public function hostAliases(array $hostAliases): Pod
    {
        foreach ($hostAliases as $key => $value) {
            $this->hostAlias[] = $value;
        }
        return $this;
    }

    /**
     * Specifies the hostname of the Pod If not specified, the pod's hostname
     * will be set to a system-defined value.
     *
     * @param string $name
     *
     * @return Pod
     */
    public function hostname(string $name): Pod
    {
        $this->hostname = $name;
        return $this;
    }

    /**
     * Set the Operating System name.
     * It can be one of linux|windows.
     *
     * @param OperatingSystem $os
     *
     * @return Pod
     */
    public function osName(OperatingSystem $os): Pod
    {
        $this->osName = $os->value;
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
        $this->restartPolicy = $policy->value;
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
     * If specified, the fully qualified Pod hostname will be:
     *   <hostname>.<subdomain>.<pod namespace>.svc.<cluster domain>
     * If not specified, the pod will not have a domainname at all.
     *
     * @param string $name
     *
     * @return Pod
     */
    public function subdomain(string $name): Pod
    {
        $this->subdomain = $name;
        return $this;
    }

    /**
     * The grace period is the duration in seconds after the processes running
     * in the pod are sent a termination signal and the time when the processes
     * are forcibly halted with a kill signal.
     *
     * @param int $seconds
     *
     * @return Pod
     */
    public function terminationGracePeriodSeconds(int $seconds): Pod
    {
        self::checkNegativeValue($seconds);

        $this->terminationGracePeriodSeconds = $seconds;
        return $this;
    }

    /**
     * Return an array as a definition of the resource.
     *
     * @return array
     */
    public function toArray(): array
    {
        $this->resource = parent::getBaseArrayDefinition();

        $this->fillContainersInfo();
        $this->fillHostNameAndNameResolution();
        $this->fillLifecycleInfo();
        $this->fillServiceAccountInfo();
        $this->fillSchedulingInfo();
        $this->fillVolumesInfo();

        return $this->resource;
    }

    private static function checkNegativeValue(int $value): void
    {
        if ($value < 0) {
            throw new NegativeIntegerNotAllowedException();
        }
    }

    private function fillContainersInfo(): void
    {
        $this->setContainers();
        $this->setInitContainers();
        $this->setImagePullSecrets();
        $this->setPodOS();
    }

    private function fillHostNameAndNameResolution(): void
    {
        $this->setHostName();
        $this->setSubdomain();
        $this->setHostAliases();
        $this->setDnsConfigNameservers();
        $this->setDnsConfigOptions();
        $this->setDnsConfigSearches();
        $this->setDnsPolicy();
    }

    private function fillLifecycleInfo(): void
    {
        $this->setActiveDeadlineSeconds();
        $this->setRestartPolicy();
        $this->setTerminationGracePeriodSeconds();
    }

    private function fillSchedulingInfo(): void
    {
        $this->setNodeSelectors();
    }

    private function fillServiceAccountInfo(): void
    {
        $this->setServiceAccountName();
        $this->setAutomountServiceAccountToken();
    }

    private function fillVolumesInfo(): void
    {
        //
    }

    private function setActiveDeadlineSeconds(): void
    {
        if ($this->checkProperty('activeDeadlineSeconds')) {
            $this->resource['spec']['activeDeadlineSeconds'] = $this->activeDeadlineSeconds;
        }
    }

    private function setAutomountServiceAccountToken(): void
    {
        if ($this->checkProperty('automountServiceAccountToken')) {
            $this->resource['spec']['automountServiceAccountToken'] = $this->automountServiceAccountToken;
        }
    }

    private function setContainers(): void
    {
        if ($this->checkProperty('containers')) {
            $this->resource['spec']['containers'] = $this->containers;
        }
    }

    private function setDnsConfigNameservers(): void
    {
        if ($this->checkProperty('dnsConfigNameservers')) {
            $this->resource['spec']['dnsConfig']['nameservers'] = $this->dnsConfigNameservers;
        }
    }

    private function setDnsConfigOptions(): void
    {
        if ($this->checkProperty('dnsConfigOptions')) {
            $this->resource['spec']['dnsConfig']['options'] = $this->dnsConfigOptions;
        }
    }

    private function setDnsConfigSearches(): void
    {
        if ($this->checkProperty('dnsConfigSearches')) {
            $this->resource['spec']['dnsConfig']['searches'] = $this->dnsConfigSearches;
        }
    }

    private function setDnsPolicy(): void
    {
        if ($this->checkProperty('dnsPolicy')) {
            $this->resource['spec']['dnsPolicy'] = $this->dnsPolicy;
        }
    }

    private function setHostAliases(): void
    {
        if ($this->checkProperty('hostAlias')) {
            $this->resource['spec']['hostAliases'] = $this->hostAlias;
        }
    }

    private function setHostName(): void
    {
        if ($this->checkProperty('hostname')) {
            $this->resource['spec']['hostname'] = $this->hostname;
        }
    }

    private function setImagePullSecrets(): void
    {
        if ($this->checkProperty('imagePullSecrets')) {
            $this->resource['spec']['imagePullSecrets'] = $this->imagePullSecrets;
        }
    }

    private function setInitContainers(): void
    {
        if ($this->checkProperty('initContainers')) {
            $this->resource['spec']['initContainers'] = $this->initContainers;
        }
    }

    private function setNodeSelectors(): void
    {
        if ($this->checkProperty('nodeSelectors')) {
            $this->resource['spec']['nodeSelector'] = $this->nodeSelectors;
        }
    }

    private function setPodOS(): void
    {
        if ($this->checkProperty('osName')) {
            $this->resource['spec']['os']['name'] = $this->osName;
        }
    }

    private function setRestartPolicy(): void
    {
        if ($this->checkProperty('restartPolicy')) {
            $this->resource['spec']['restartPolicy'] = $this->restartPolicy;
        }
    }

    private function setServiceAccountName(): void
    {
        if ($this->checkProperty('serviceAccount')) {
            $this->resource['spec']['serviceAccount'] = $this->serviceAccount;
        }
    }

    private function setSubdomain(): void
    {
        if ($this->checkProperty('subdomain')) {
            $this->resource['spec']['subdomain'] = $this->subdomain;
        }
    }

    private function setTerminationGracePeriodSeconds(): void
    {
        if ($this->checkProperty('terminationGracePeriodSeconds')) {
            $this->resource['spec']['terminationGracePeriodSeconds'] = $this->terminationGracePeriodSeconds;
        }
    }
}
