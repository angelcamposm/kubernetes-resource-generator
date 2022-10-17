<?php

namespace Acamposm\KubernetesResourceGenerator\Reference\Labels;

final class PodLabels extends AllObjectLabels
{
    /**
     * When this annotation is set to "true", the cluster autoscaler is allowed
     * to evict a Pod even if other rules would normally prevent that.
     * The cluster autoscaler never evicts Pods that have this annotation
     * explicitly set to "false";
     *
     * @example cluster-autoscaler.kubernetes.io/safe-to-evict: true
     * @return string[]
     */
    public static function safeToEvict(): array
    {
        return ['cluster-autoscaler.kubernetes.io/safe-to-evict' => 'true'];
    }

    /**
     * When this annotation is set to "true", the cluster autoscaler is allowed
     * to evict a Pod even if other rules would normally prevent that.
     * The cluster autoscaler never evicts Pods that have this annotation
     * explicitly set to "false";
     *
     * @example cluster-autoscaler.kubernetes.io/safe-to-evict: false
     * @return string[]
     */
    public static function unsafeToEvict(): array
    {
        return ['cluster-autoscaler.kubernetes.io/safe-to-evict' => 'false'];
    }


}
