<?php

namespace Acamposm\KubernetesResourceGenerator\Enums;

/**
 * Set DNS policy for the pod.
 *
 * @note
 *   DNS parameters given in DNSConfig will be merged with the policy selected
 *   with DNSPolicy.
 *   To have DNS options set along with hostNetwork, you have to specify DNS
 *   policy explicitly to 'ClusterFirstWithHostNet'.
 */
enum DnsPolicy: string
{
    case CLUSTER_FIRST = 'ClusterFirst';
    case CLUSTER_FIRST_WITH_HOST_NET = 'ClusterFirstWithHostNet';
    case DEFAULT = 'Default';
    case NONE = 'None';
}
