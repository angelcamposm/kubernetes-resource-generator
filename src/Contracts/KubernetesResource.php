<?php

namespace Acamposm\KubernetesResourceGenerator\Contracts;

interface KubernetesResource
{
    /**
     * Set the name of the resource.
     *
     * @param string $name
     *
     * @return KubernetesResource
     */
    public function name(string $name): KubernetesResource;

    /**
     * Add the namespace to a resource.
     *
     * @param string $namespace
     *
     * @return KubernetesResource
     */
    public function namespace(string $namespace): KubernetesResource;

    /**
     * Add an annotation to a resource.
     *
     * @param string $key
     * @param string $value
     *
     * @return KubernetesResource
     */
    public function addAnnotation(string $key, string $value): KubernetesResource;

    /**
     * Add a label to a resource.
     *
     * @param string $key
     * @param string $value
     *
     * @return KubernetesResource
     */
    public function addLabel(string $key, string $value): KubernetesResource;

    /**
     * Add a selector to a resource.
     *
     * @param string $label
     * @param string $value
     *
     * @return KubernetesResource
     */
    public function addSelector(string $label, string $value): KubernetesResource;

    /**
     * Return an array as a definition of the resource.
     *
     * @return array
     */
    public function toArray(): array;
}