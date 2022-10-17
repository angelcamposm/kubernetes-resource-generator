<?php

namespace Acamposm\KubernetesResourceGenerator\Reference\Labels;

abstract class AllObjectLabels
{
    /**
     * The component within the architecture.
     *
     * @example app.kubernetes.io/component: "database"
     * @param string $component
     * @return string[]
     */
    public static function component(string $component): array
    {
        return ['app.kubernetes.io/component' => $component];
    }

    /**
     * A unique name identifying the instance of an application.
     * To assign a non-unique name, use app.kubernetes.io/name.
     *
     * @example app.kubernetes.io/instance: "mysql-abcxzy"
     * @param string $instance
     * @return string[]
     */
    public static function instance(string $instance): array
    {
        return ['app.kubernetes.io/instance' => $instance];
    }

    /**
     * The tool being used to manage the operation of an application
     *
     * @example app.kubernetes.io/managed-by: "helm"
     * @param string $manager
     * @return string[]
     */
    public static function managedBy(string $manager): array
    {
        return ['app.kubernetes.io/managed-by' => $manager];
    }

    /**
     * The name of the application.
     *
     * @example app.kubernetes.io/name: "mysql"
     * @param string $name
     * @return string[]
     */
    public static function name(string $name): array
    {
        return ['app.kubernetes.io/name' => $name];
    }

    /**
     * The name of a higher-level application this one is part of.
     *
     * @example app.kubernetes.io/part-of: "wordpress"
     * @param String $name
     * @return String[]
     */
    public static function partOf(String $name): array
    {
        return ['app.kubernetes.io/part-of' => $name];
    }

    /**
     * The current version of the application.
     * @example app.kubernetes.io/version: "5.7.21"
     * @param string $version
     * @return string[]
     */
    public static function version(string $version): array
    {
        return ['app.kubernetes.io/version' => $version];
    }


}
