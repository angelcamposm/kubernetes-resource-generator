<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\Helpers\ResourceUnit;
use Acamposm\KubernetesResourceGenerator\K8sResource;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

class Container
{
    use Exportable;

    private array $args = [];
    private array $command = [];
    private array $environment = [];
    private string $image;
    private string $name;
    private string $cpuLimit;
    private string $cpuRequest;
    private string $memoryLimit;
    private string $memoryRequest;
    private array $volumeMounts = [];

    /**
     * the container's name
     *
     * @param string $name
     *
     * @return Container
     */
    public function name(string $name): Container
    {
        $this->name = $name;
        return $this;
    }

    /**
     * the container's image
     *
     * @param string $image
     *
     * @return Container
     */
    public function image(string $image): Container
    {
        $this->image = $image;
        return $this;
    }

    public function setCpuLimit(string $value): Container
    {
        $this->cpuLimit = ResourceUnit::validate($value);
        return $this;
    }

    public function setCpuRequest(string $value): Container
    {
        $this->cpuRequest = ResourceUnit::validate($value);
        return $this;
    }

    public function addEnvVariable(string $name, string $value): Container
    {
        $this->environment[] = [
            'name' => $name,
            'value' => $value,
        ];
        return $this;
    }

    public function setMemoryLimit(string $value): Container
    {
        $this->memoryLimit = ResourceUnit::validate($value);
        return $this;
    }

    public function setMemoryRequest(string $value): Container
    {
        $this->memoryRequest = ResourceUnit::validate($value);
        return $this;
    }

    public function checkProperty(string $name): bool
    {
        return isset($this->$name) && !empty($this->$name);
    }

    public function toArray(): array
    {
        $container = [];

        $properties = ['name', 'image', 'environment', 'volumeMounts'];

        foreach ($properties as $property) {
            if ($this->checkProperty($property)) {
                $container[$property] = $this->$property;
            }
        }

        if ($this->checkProperty('cpuLimit') || $this->checkProperty('memoryLimit')) {
            $container['resources'] = [
                'limits' => []
            ];
        }

        if ($this->checkProperty('cpuRequests') || $this->checkProperty('memoryRequests')) {
            $container['resources'] = [
                'requests' => []
            ];
        }

        if ($this->checkProperty('cpuLimit')) {
            $container['resources']['limits']['cpu'] = $this->cpuLimit;
        }

        if ($this->checkProperty('cpuRequest')) {
            $container['resources']['requests']['cpu'] = $this->cpuRequest;
        }

        if ($this->checkProperty('memoryLimit')) {
            $container['resources']['limits']['memory'] = $this->memoryLimit;
        }

        if ($this->checkProperty('memoryRequest')) {
            $container['resources']['requests']['memory'] = $this->memoryRequest;
        }

        return $container;
    }
}
