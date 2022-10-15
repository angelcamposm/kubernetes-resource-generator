<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\Enums\ImagePullPolicy;
use Acamposm\KubernetesResourceGenerator\Helpers\ResourceUnit;
use Acamposm\KubernetesResourceGenerator\Traits\CanCheckProperties;
use Acamposm\KubernetesResourceGenerator\Traits\Exportable;

final class Container
{
    use CanCheckProperties, Exportable;

    private array $args = [];
    private array $commands = [];
    private array $environment = [];
    private string $image;
    private ImagePullPolicy $imagePullPolicy;
    private string $name;
    private string $cpuLimit;
    private string $cpuRequest;
    private string $memoryLimit;
    private string $memoryRequest;
    private array $ports;
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

    public function addCommands(array $commands): Container
    {
        foreach ($commands as $key => $command) {
            $this->commands[] = $command;
        }
        return $this;
    }

    public function imagePullPolicy(ImagePullPolicy $imagePullPolicy): Container
    {
        $this->imagePullPolicy = $imagePullPolicy;
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

    public function addPorts(array $ports): Container
    {
        foreach ($ports as $port) {
            $this->ports[] = $port;
        }
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

    public function toArray(): array
    {
        $container = [];

        $properties = ['name', 'image', 'environment', 'ports', 'volumeMounts'];

        foreach ($properties as $property) {
            if ($this->checkProperty($property)) {
                $container[$property] = $this->$property;
            }
        }

        if ($this->checkProperty('commands')) {
            $container['command'] =  $this->commands;
        }

        if ($this->checkProperty('imagePullPolicy')) {
            $container['imagePullPolicy'] = $this->imagePullPolicy->value;
        }

        if ($this->checkProperty('cpuLimit')) {
            $container['resources']['limits']['cpu'] = self::addSimpleQuotesTo($this->cpuLimit);
        }

        if ($this->checkProperty('cpuRequest')) {
            $container['resources']['requests']['cpu'] = self::addSimpleQuotesTo($this->cpuRequest);
        }

        if ($this->checkProperty('memoryLimit')) {
            $container['resources']['limits']['memory'] = self::addSimpleQuotesTo($this->memoryLimit);
        }

        if ($this->checkProperty('memoryRequest')) {
            $container['resources']['requests']['memory'] = self::addSimpleQuotesTo($this->memoryRequest);
        }

        ksort($container);

        return $container;
    }

    /**
     * add simple quotes to the value.
     *
     * @param string $value
     *
     * @return string
     */
    private static function addSimpleQuotesTo(string $value): string
    {
        return ResourceUnit::isInteger($value) ? $value : '^'.$value.'^';
    }
}
