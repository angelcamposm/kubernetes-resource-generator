<?php

namespace Acamposm\KubernetesResourceGenerator\Enums;

/**
 * The imagePullPolicy for a container and the tag of the image affect when the
 * kubelet attempts to pull (download) the specified image.
 */
enum ImagePullPolicy: string
{
    case ALWAYS = 'Always';
    case IF_NOT_PRESENT = 'IfNotPresent';
    case NEVER = 'Never';
}
