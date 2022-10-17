<?php

namespace Acamposm\KubernetesResourceGenerator\Reference\Annotations;

final class ServiceAccountAnnotations extends AllObjectAnnotations
{
    /**
     * This annotation indicates that pods running as this service account may
     * only reference Secret API objects specified in the service account's
     * secrets field.
     * The value for this annotation must be true to take effect.
     *
     * @example kubernetes.io/enforce-mountable-secrets: "true"
     * @return string[]
     */
    public static function enforceMountableSecrets(): array
    {
        return ['kubernetes.io/enforce-mountable-secrets' => 'true'];
    }
}
