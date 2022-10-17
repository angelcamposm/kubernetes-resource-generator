<?php

namespace Acamposm\KubernetesResourceGenerator\Reference\Annotations;

use Acamposm\KubernetesResourceGenerator\Reference\Labels\AllObjectLabels;

final class PodAnnotations extends AllObjectLabels
{
    /**
     * Set Pod Deletion Cost which allows users to influence ReplicaSet
     * downscaling order. The annotation parses into an int32 type.
     *
     * @example controller.kubernetes.io/pod-deletion-cost: "10"
     * @param int $cost
     * @return int[]
     */
    public static function deletionCost(int $cost): array
    {
        return ['controller.kubernetes.io/pod-deletion-cost' => $cost];
    }

    /**
     * The value of the annotation is the container name that is default for this Pod.
     *
     * @example kubectl.kubernetes.io/default-container: "front-end-app"
     * @param string $name
     * @return string[]
     */
    public static function defaultContainer(string $name): array
    {
        return ['kubectl.kubernetes.io/default-container' => $name];
    }


}
