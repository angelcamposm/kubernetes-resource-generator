<?php

declare(strict_types=1);

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Enums\DnsPolicy;
use Acamposm\KubernetesResourceGenerator\Enums\OperatingSystem;
use Acamposm\KubernetesResourceGenerator\Enums\RestartPolicy;
use Acamposm\KubernetesResourceGenerator\Helpers\HostAlias;
use Acamposm\KubernetesResourceGenerator\Reference\Annotations\PodAnnotations;
use Acamposm\KubernetesResourceGenerator\Reference\Labels\PodLabels;
use Acamposm\KubernetesResourceGenerator\Resources\Pod;
use Acamposm\KubernetesResourceGenerator\Tests\Helpers\Reflection;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class PodTest extends TestCase
{
    protected Pod $pod;
    protected array $annotations;
    protected array $hostAliases;
    protected array $imagePullSecrets;
    protected array $labels;

    private const ACTIVE_DEADLINE_SECONDS = 10;
    private const HOST_NAME = 'host-name';
    private const NAME = 'pod-name';
    private const NAMESPACE = 'pod-namespace';
    private const PRIMARY_IMAGE_PULL_SECRET = 'my-private-registry-access-token';
    private const REPLICAS = 3;
    private const SECONDARY_IMAGE_PULL_SECRET = 'my-secondary-access-token';
    private const SERVICE_ACCOUNT = 'pod-service-account';

    protected function setUp(): void
    {
        parent::setUp();

        $this->pod = new Pod();
        $this->setAnnotations();
        $this->setLabels();
        $this->setHostAliases();
        $this->setImagePullSecrets();
    }

    private function setAnnotations(): void
    {
        $this->annotations = array_merge(
            PodAnnotations::deletionCost(500),
            PodAnnotations::defaultContainer('my-app-container'),
        );
    }

    private function setLabels(): void
    {
        $this->labels = array_merge(
            PodLabels::component('database'),
            PodLabels::instance('my-awesome-application-xyz'),
            PodLabels::managedBy('Kustomize'),
            PodLabels::name('my-awesome-application'),
            PodLabels::partOf('my-awesome-application'),
            PodLabels::version('1.0.0'),
        );
    }

    private function setHostAliases(): void
    {
        $this->hostAliases = [
            HostAlias::get('my-awesome-app.local', '127.0.0.1')
        ];
    }

    private function setImagePullSecrets(): void
    {
        $this->imagePullSecrets = [
            self::PRIMARY_IMAGE_PULL_SECRET,
            self::SECONDARY_IMAGE_PULL_SECRET,
        ];
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(Pod::class, $this->pod);
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetPodName(): void
    {
        $this->pod->name(self::NAME);

        $this->assertEquals(
            expected: self::NAME,
            actual: Reflection::getPropertyValue($this->pod,'name')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetNamespace(): void
    {
        $this->pod->namespace(self::NAMESPACE);

        $this->assertEquals(
            expected: self::NAMESPACE,
            actual: Reflection::getPropertyValue($this->pod,'namespace')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetOsNameToLinux(): void
    {
        $this->pod->osName(OperatingSystem::LINUX);

        $this->assertEquals(
            expected: OperatingSystem::LINUX,
            actual: Reflection::getPropertyValue($this->pod,'operatingSystem')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetOsNameToWindows(): void
    {
        $this->pod->osName(OperatingSystem::WINDOWS);

        $this->assertEquals(
            expected: OperatingSystem::WINDOWS,
            actual: Reflection::getPropertyValue($this->pod,'operatingSystem')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetReplicaCount(): void
    {
        $this->pod->replicas(self::REPLICAS);

        $this->assertEquals(
            expected: self::REPLICAS,
            actual: Reflection::getPropertyValue($this->pod,'replicas')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetRestartPolicy(): void
    {
        $this->pod->restartPolicy(RestartPolicy::ALWAYS);

        $this->assertEquals(
            expected: RestartPolicy::ALWAYS,
            actual: Reflection::getPropertyValue($this->pod, 'restartPolicy')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetServiceAccount(): void
    {
        $this->pod->serviceAccount(self::SERVICE_ACCOUNT);

        $this->assertEquals(
            expected: self::SERVICE_ACCOUNT,
            actual: Reflection::getPropertyValue($this->pod, 'serviceAccount')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetImagePullSecret(): void
    {
        $this->pod->addImagePullSecret(self::PRIMARY_IMAGE_PULL_SECRET);

        $this->assertEquals(
            expected: ['name' => self::PRIMARY_IMAGE_PULL_SECRET],
            actual: Reflection::getPropertyValue($this->pod, 'imagePullSecrets')[0]
        );
    }

    public function testItCanReturnAnArrayWithFullExample(): array
    {
        $this->pod
            ->name(self::NAME)
            ->namespace(self::NAMESPACE)
            ->addAnnotations($this->annotations)
            ->addLabels($this->labels)
            ->activeDeadlineSeconds(self::ACTIVE_DEADLINE_SECONDS)
            ->automountServiceAccountToken()
            ->dnsPolicy(DnsPolicy::DEFAULT)
            ->addImagePullSecrets($this->imagePullSecrets)
            ->hostAliases($this->hostAliases)
            ->hostName(self::HOST_NAME)
            ->osName(OperatingSystem::LINUX)
            ->serviceAccount(self::SERVICE_ACCOUNT)
            ->replicas(self::REPLICAS)
            ->restartPolicy(RestartPolicy::ALWAYS);

        $pod = $this->pod->toArray();

        $this->assertIsArray($pod);
        $this->assertArrayHasKey('metadata', $pod);
        $this->assertArrayHasKey('spec', $pod);

        return $pod;
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return Void
     */
    public function testResultContainsKeyName(array $pod): void
    {
        $this->assertArrayHasKey('name', $pod['metadata']);
        $this->assertEquals(self::NAME, $pod['metadata']['name']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyNamespace(array $pod): void
    {
        $this->assertArrayHasKey('namespace', $pod['metadata']);
        $this->assertEquals(self::NAMESPACE, $pod['metadata']['namespace']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsAnnotationsArray(array $pod): void
    {
        $this->assertIsArray($pod['metadata']['annotations']);
        $this->assertEquals($this->annotations, $pod['metadata']['annotations']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsLabelsArray(array $pod): void
    {
        $this->assertIsArray($pod['metadata']['labels']);
        $this->assertEquals($this->labels, $pod['metadata']['labels']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyActiveDeadlineSeconds(array $pod): void
    {
        $this->assertArrayHasKey('activeDeadlineSeconds', $pod['spec']);
        $this->assertEquals(self::ACTIVE_DEADLINE_SECONDS, $pod['spec']['activeDeadlineSeconds']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyAutomountServiceAccountToken(array $pod): void
    {
        $this->assertArrayHasKey('automountServiceAccountToken', $pod['spec']);
        $this->assertEquals(true, $pod['spec']['automountServiceAccountToken']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyDnsPolicy(array $pod): void
    {
        $this->assertArrayHasKey('dnsPolicy', $pod['spec']);
        $this->assertEquals(DnsPolicy::DEFAULT->value, $pod['spec']['dnsPolicy']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyImagePullSecrets(array $pod): void
    {
        $this->assertArrayHasKey('imagePullSecrets', $pod['spec']);
        $this->assertEquals([
            ['name' => self::PRIMARY_IMAGE_PULL_SECRET],
            ['name' => self::SECONDARY_IMAGE_PULL_SECRET],
        ], $pod['spec']['imagePullSecrets']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyHostAliases(array $pod): void
    {
        $this->assertArrayHasKey('hostAliases', $pod['spec']);
        $this->assertEquals([
            HostAlias::get('my-awesome-app.local','127.0.0.1')
        ], $pod['spec']['hostAliases']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyHostName(array $pod): void
    {
        $this->assertArrayHasKey('hostname', $pod['spec']);
        $this->assertEquals(self::HOST_NAME, $pod['spec']['hostname']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyOperatingSystemName(array $pod): void
    {
        $this->assertArrayHasKey('os', $pod['spec']);
        $this->assertEquals(OperatingSystem::LINUX->value, $pod['spec']['os']['name']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyReplicas(array $pod): void
    {
        $this->assertArrayHasKey('replicas', $pod['spec']);
        $this->assertEquals(self::REPLICAS, $pod['spec']['replicas']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsKeyRestartPolicy(array $pod): void
    {
        $this->assertArrayHasKey('restartPolicy', $pod['spec']);
        $this->assertEquals(RestartPolicy::ALWAYS->value, $pod['spec']['restartPolicy']);
    }

    /**
     * @depends testItCanReturnAnArrayWithFullExample
     * @param array $pod
     * @return void
     */
    public function testResultContainsServiceAccount(array $pod): void
    {
        $this->assertArrayHasKey('serviceAccount', $pod['spec']);
        $this->assertEquals(self::SERVICE_ACCOUNT, $pod['spec']['serviceAccount']);
    }
}
