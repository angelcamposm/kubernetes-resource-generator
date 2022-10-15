<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Helpers\KubernetesRecommendedLabels;
use Acamposm\KubernetesResourceGenerator\Tests\Helpers\Reflection;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class LabelsTest extends TestCase
{
    private const COMPONENT = 'web-server';
    private const INSTANCE = 'my-application-instance-xyz';
    private const MANAGED_BY = 'Kustomize.io';
    private const NAME = 'my-application';
    private const PART_OF = 'my-application';
    private const VERSION = '1.3.127';

    protected KubernetesRecommendedLabels $labels;

    protected function setUp(): void
    {
        parent::setUp();
        $this->labels = new KubernetesRecommendedLabels();
    }

    public function testItCanCreateAnInstance(): void
    {
        $instance = new KubernetesRecommendedLabels();

        $this->assertInstanceOf(KubernetesRecommendedLabels::class, $instance);
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanAssignApplicationComponentLabel(): void
    {
        $this->labels->component(self::COMPONENT);

        $labelsValue = $this->getLabelsValue();

        $this->assertArrayHasKey('app.kubernetes.io/component', $labelsValue);
        $this->assertEquals(self::COMPONENT, $labelsValue['app.kubernetes.io/component']);
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanAssignApplicationInstanceLabel(): void
    {
        $this->labels->instance(self::INSTANCE);

        $labelsValue = $this->getLabelsValue();

        $this->assertArrayHasKey('app.kubernetes.io/instance', $labelsValue);
        $this->assertEquals(self::INSTANCE, $labelsValue['app.kubernetes.io/instance']);
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanAssignApplicationManagedByLabel(): void
    {
        $this->labels->managedBy(self::MANAGED_BY);

        $labelsValue = $this->getLabelsValue();

        $this->assertArrayHasKey('app.kubernetes.io/managed-by', $labelsValue);
        $this->assertEquals(self::MANAGED_BY, $labelsValue['app.kubernetes.io/managed-by']);
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanAssignApplicationNameLabel(): void
    {
        $this->labels->name(self::NAME);

        $labelsValue = $this->getLabelsValue();

        $this->assertArrayHasKey('app.kubernetes.io/name', $labelsValue);
        $this->assertEquals(self::NAME, $labelsValue['app.kubernetes.io/name']);
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanAssignApplicationPartOfLabel(): void
    {
        $this->labels->partOf(self::PART_OF);

        $labelsValue = $this->getLabelsValue();

        $this->assertArrayHasKey('app.kubernetes.io/part-of', $labelsValue);
        $this->assertEquals(self::PART_OF, $labelsValue['app.kubernetes.io/part-of']);
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanAssignApplicationVersionLabel(): void
    {
        $this->labels->version(self::VERSION);

        $labelsValue = $this->getLabelsValue();

        $this->assertArrayHasKey('app.kubernetes.io/version', $labelsValue);
        $this->assertEquals(self::VERSION, $labelsValue['app.kubernetes.io/version']);
    }

    public function testItCanGetAllLabels(): void
    {
        $labels = $this->labels
            ->component(self::COMPONENT)
            ->instance(self::INSTANCE)
            ->managedBy(self::MANAGED_BY)
            ->name(self::NAME)
            ->partOf(self::PART_OF)
            ->version(self::VERSION)
            ->toArray();

        $this->assertIsArray($labels);
        $this->assertArrayHasKey('app.kubernetes.io/component', $labels);
        $this->assertArrayHasKey('app.kubernetes.io/instance', $labels);
        $this->assertArrayHasKey('app.kubernetes.io/managed-by', $labels);
        $this->assertArrayHasKey('app.kubernetes.io/name', $labels);
        $this->assertArrayHasKey('app.kubernetes.io/part-of', $labels);
        $this->assertArrayHasKey('app.kubernetes.io/version', $labels);
    }

    /**
     * @throws ReflectionException
     */
    private function getLabelsValue(): array
    {
        return Reflection::getPropertyValue($this->labels, 'labels');
    }
}
