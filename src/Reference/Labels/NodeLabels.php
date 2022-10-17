<?php

namespace Acamposm\KubernetesResourceGenerator\Reference\Labels;

final class NodeLabels extends AllObjectLabels
{
    /**
     * A zone represents a logical failure domain.
     *
     * @example topology.kubernetes.io/region: "us-east-1"
     * @param string $name
     * @return string[]
     */
    public static function region(string $name): array
    {
        return ['topology.kubernetes.io/region' => $name];
    }

    /**
     * A region represents a larger domain, made up of one or more zones.
     *
     * @example topology.kubernetes.io/zone: "us-east-1c"
     * @param string $name
     * @return string[]
     */
    public static function zone(string $name): array
    {
        return ['topology.kubernetes.io/zone' => $name];
    }
}
