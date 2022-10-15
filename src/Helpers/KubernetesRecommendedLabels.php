<?php

namespace Acamposm\KubernetesResourceGenerator\Helpers;

/**
 * Kubernetes recommended labels.
 *
 * You can visualize and manage Kubernetes objects with more tools than kubectl
 * and the dashboard. A common set of labels allows tools to work interoperable,
 * describing objects in a common manner that all tools can understand.
 */
class KubernetesRecommendedLabels
{
    protected array $labels = [];

    /**
     * The component within the architecture.
     * Ex: database, webserver, cache, etc...
     *
     * @param string $component
     * @return KubernetesRecommendedLabels
     */
    public function component(string $component): KubernetesRecommendedLabels
    {
        $this->labels['app.kubernetes.io/component'] = $component;
        return $this;
    }

    /**
     * A unique name identifying the instance of an application.
     * Ex: mysql-abcxzy
     *
     * @param string $instance
     *
     * @return KubernetesRecommendedLabels
     */
    public function instance(string $instance): KubernetesRecommendedLabels
    {
        $this->labels['app.kubernetes.io/instance'] = $instance;
        return $this;
    }

    /**
     * The tool being used to manage the operation of an application.
     * Ex: helm
     *
     * @param string $managedBy
     *
     * @return KubernetesRecommendedLabels
     */
    public function managedBy(string $managedBy): KubernetesRecommendedLabels
    {
        $this->labels['app.kubernetes.io/managed-by'] = $managedBy;
        return $this;
    }

    /**
     * The name of the application.
     * Ex: mysql
     *
     * @param string $name
     *
     * @return KubernetesRecommendedLabels
     */
    public function name(string $name): KubernetesRecommendedLabels
    {
        $this->labels['app.kubernetes.io/name'] = $name;
        return $this;
    }

    /**
     * The name of a higher level application this one is part of.
     * Ex: WordPress
     *
     * @param string $member
     *
     * @return KubernetesRecommendedLabels
     */
    public function partOf(string $member): KubernetesRecommendedLabels
    {
        $this->labels['app.kubernetes.io/part-of'] = $member;
        return $this;
    }

    /**
     * The current version of the application.
     * Ex: a semantic version, revision hash, etc.
     *
     * @param string $version
     *
     * @return KubernetesRecommendedLabels
     */
    public function version(string $version): KubernetesRecommendedLabels
    {
        $this->labels['app.kubernetes.io/version'] = $version;
        return $this;
    }

    public function toArray(): array
    {
        return $this->labels;
    }
}
