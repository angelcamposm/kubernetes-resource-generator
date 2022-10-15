<?php

namespace Acamposm\KubernetesResourceGenerator\Enums;

enum RestartPolicy: string
{
    case ALWAYS = 'Always';
    case ON_FAILURE = 'OnFailure';
    case NEVER = 'Never';
}
