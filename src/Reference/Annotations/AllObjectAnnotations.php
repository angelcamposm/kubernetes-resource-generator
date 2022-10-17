<?php

namespace Acamposm\KubernetesResourceGenerator\Reference\Annotations;

abstract class AllObjectAnnotations
{
    /**
     * This annotation is the best guess at why something was changed.
     * It is populated when adding --record to a kubectl command that may
     * change an object.
     *
     * @example kubernetes.io/change-cause: "kubectl edit --record deployment foo"
     * @param string $message
     * @return string[]
     */
    public static function changeCause(string $message): array
    {
        return ['kubernetes.io/change-cause' => $message];
    }

    /**
     * Used for describing specific behaviour of given object.
     * @example kubernetes.io/description: "Description of K8s object."
     * @param string $description
     * @return string[]
     */
    public static function description(string $description): array
    {
        return ['kubernetes.io/description' => $description];
    }
}
