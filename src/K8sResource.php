<?php

namespace Acamposm\KubernetesResourceGenerator;

use Acamposm\KubernetesResourceGenerator\Contracts\KubernetesResource;
use Acamposm\KubernetesResourceGenerator\Traits\CanCheckProperties;

abstract class K8sResource implements KubernetesResource
{
    use CanCheckProperties;

    protected array $annotations = [];
    protected array $labels = [];
    protected string $name;
    protected string $namespace = '';
    protected array $selectors = [];

    /**
     * K8sResource constructor.
     *
     * @param string $kind
     * @param string $apiVersion
     */
    public function __construct(
        public string $kind,
        public string $apiVersion,
    )
    { }

    /**
     * Return an array as a definition of the resource.
     *
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * the pod's name
     *
     * @param string $name
     *
     * @return $this
     */
    public function name(string $name): K8sResource
    {
        $this->name = $name;
        return $this;
    }

    /**
     * the pod's namespace
     *
     * @param string $namespace
     *
     * @return $this
     */
    public function namespace(string $namespace): K8sResource
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * the value of the pod's annotation named <KEY>
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addAnnotation(string $key, string $value): K8sResource
    {
        $this->annotations[$key] = $value;
        return $this;
    }

    /**
     * all the pod's annotations, formatted as annotation-key="escaped-annotation-value"
     * with one annotation per line.
     *
     * @param array $annotationPairs
     *
     * @return $this
     */
    public function addAnnotations(array $annotationPairs): K8sResource
    {
        foreach ($annotationPairs as $key => $value) {
            $this->annotations[$key] = $value;
        }
        return $this;
    }

    /**
     * all the pod's labels, formatted as label-key="escaped-label-value" with
     * one label per line.
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addLabel(string $key, string $value): K8sResource
    {
        $this->labels[$key] = $value;
        return $this;
    }

    public function addLabels(array $labelPairs): K8sResource
    {
        foreach ($labelPairs as $key => $value) {
            $this->labels[$key] = $value;
        }
        return $this;
    }

    public function addSelector(string $label, string $value): K8sResource
    {
        $this->selectors[$label] = $value;
        return $this;
    }

    public function addSelectors(array $selectors): K8sResource
    {
        foreach ($selectors as $key => $value) {
            $this->selectors[$key] = $value;
        }
        return $this;
    }

    protected function checkAnnotations(): bool
    {
        return isset($this->annotations) && !empty($this->annotations);
    }

    protected function checkLabels(): bool
    {
        return isset($this->labels) && !empty($this->labels);
    }

    protected function checkName(): bool
    {
        return isset($this->name) && !empty($this->name);
    }

    protected function checkNamespace(): bool
    {
        return isset($this->namespace) && !empty($this->namespace);
    }

    protected function getBaseArrayDefinition(): array
    {
        $resource = [
            'kind' => $this->kind,
            'apiVersion' => $this->apiVersion,
        ];

        if ($this->checkName()) {
            $resource['metadata']['name'] = $this->name;
        }

        if ($this->checkNamespace()) {
            $resource['metadata']['namespace'] = $this->namespace;
        }

        if ($this->checkAnnotations()) {
            $resource['metadata']['annotations'] = $this->annotations;
        }

        if ($this->checkLabels()) {
            $resource['metadata']['labels'] = $this->labels;
        }

        return $resource;
    }
}
