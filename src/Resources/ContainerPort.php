<?php

namespace Acamposm\KubernetesResourceGenerator\Resources;

use Acamposm\KubernetesResourceGenerator\Enums\Protocol;
use Acamposm\KubernetesResourceGenerator\Exceptions\PortNumberException;
use stdClass;

final class ContainerPort
{
    private int $containerPort;
    private string $hostIp;
    private int $hostPort;
    private string $name;
    private string $protocol;

    public function __construct(
        private $portObject = new StdClass()
    ) { }

    public static function create(): ContainerPort
    {
        return new static;
    }

    /**
     * Number of port to expose on the pod's IP address.
     * This must be a valid port number, 0 < x < 65536.
     *
     * @param int $port
     *
     * @return ContainerPort
     */
    public function containerPort(int $port): ContainerPort
    {
        self::checkPortNumber($port);

        $this->containerPort = $port;
        return $this;
    }

    /**
     * What host IP to bind the external port to.
     *
     * @param string $ip
     *
     * @return ContainerPort
     */
    public function hostIp(string $ip): ContainerPort
    {
        $this->hostIp = $ip;
        return $this;
    }

    /**
     * Number of port to expose on the host.
     * If specified, this must be a valid port number, 0 < x < 65536.
     * If HostNetwork is specified, this must match ContainerPort.
     *
     * @note Most containers do not need this.
     *
     * @param int $port
     *
     * @return ContainerPort
     */
    public function hostPort(int $port): ContainerPort
    {
        self::checkPortNumber($port);

        $this->hostPort = $port;
        return $this;
    }

    /**
     * If specified, this must be an IANA_SVC_NAME and unique within the pod.
     * Each named port in a pod must have a unique name. Name for the port
     * that can be referred to by services.
     *
     * @param string $name
     *
     * @return ContainerPort
     */
    public function name(string $name): ContainerPort
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Protocol for port.
     * Must be UDP, TCP, or SCTP.
     * Defaults to "TCP".
     *
     * @param Protocol $protocol
     *
     * @return ContainerPort
     */
    public function protocol(Protocol $protocol): ContainerPort
    {
        $this->protocol = $protocol->value;
        return $this;
    }

    public function toArray(): array
    {
        if (!isset($this->containerPort)) {
            throw new PortNumberException('Container Port not set.');
        }

        $this->setPropertyValue('containerPort');
        $this->setPropertyValue('hostIp');
        $this->setPropertyValue('hostPort');
        $this->setPropertyValue('name');

        $this->portObject->protocol = $this->protocol ?? Protocol::TCP->value;

        return (array) $this->portObject;
    }

    private static function checkPortNumber(int $port): void
    {
        if ($port < 0) {
            throw new PortNumberException('Port number can\'t be less than 0');
        }

        if ($port > 65536) {
            throw new PortNumberException('Port number can\'t be greater than 65536');
        }
    }

    private function setPropertyValue(string $property): void
    {
        if (isset($this->$property)) {
            $this->portObject->$property = $this->$property;
        }
    }
}
