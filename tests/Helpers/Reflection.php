<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Helpers;

use Acamposm\KubernetesResourceGenerator\Contracts\KubernetesResource;
use ReflectionClass;
use ReflectionException;

class Reflection
{
    /**
     * @throws ReflectionException
     */
    public static function getPropertyValue(mixed $resource, string $property): mixed
    {
        $reflectionClass = new ReflectionClass($resource);
        $reflectionProperty = $reflectionClass->getProperty($property);
        return $reflectionProperty->getValue($resource);
    }
}