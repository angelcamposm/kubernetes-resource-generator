<?php

namespace Acamposm\KubernetesResourceGenerator\Enums;

enum Protocol: string
{
    case SCTP = 'SCTP';
    case TCP = 'TCP';
    case UDP = 'UDP';
}
