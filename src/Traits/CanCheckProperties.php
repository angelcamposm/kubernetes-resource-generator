<?php

namespace Acamposm\KubernetesResourceGenerator\Traits;

trait CanCheckProperties
{
    public function checkProperty(string $name): bool
    {
        return isset($this->$name) && !empty($this->$name);
    }
}