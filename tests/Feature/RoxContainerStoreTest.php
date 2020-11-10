<?php

namespace Krak\SymfonyRox\Tests\Feature;

use Krak\SymfonyRox\RoxContainerStore;
use Krak\SymfonyRox\Test\StubRoxSetup;
use Krak\SymfonyRox\Tests\Feature\Fixture\CategoryRoxContainer;
use Krak\SymfonyRox\Tests\Feature\Fixture\ProductRoxContainer;

final class RoxContainerStoreTest extends \PHPUnit\Framework\TestCase
{
    use RoxSetupSteps;

    /** @var StubRoxSetup */
    private $roxSetup;
    /** @var RoxContainerStore */
    private $roxContainerStore;
    private $containerAccess = [];

    /** @test */
    public function initializes_the_rox_container_on_first_access() {
        $this->given_the_rox_container_store_is_setup_with_containers($this->productAndCategoryContainers());
        $this->when_the_rox_container_store_is_accessed_for_classes([ProductRoxContainer::class]);
        $this->then_the_total_registered_rox_containers_is(2);
        $this->then_rox_setup_is_called(1);
        $this->then_the_accessed_containers_match([
            ProductRoxContainer::class,
        ]);
    }

    /** @test */
    public function only_calls_setup_once_on_subsequent_accesses() {
        $this->given_the_rox_container_store_is_setup_with_containers($this->productAndCategoryContainers());
        $this->when_the_rox_container_store_is_accessed_for_classes([ProductRoxContainer::class, CategoryRoxContainer::class]);
        $this->then_the_total_registered_rox_containers_is(2);
        $this->then_rox_setup_is_called(1);
        $this->then_the_accessed_containers_match([
            ProductRoxContainer::class,
            CategoryRoxContainer::class,
        ]);
    }

    /** @test */
    public function throws_exception_if_container_store_does_not_exist() {
        $this->given_the_rox_container_store_is_setup_with_containers($this->productAndCategoryContainers());
        $this->when_the_rox_container_store_is_accessed_for_classes(['NonExistentClass']);
        $this->then_rox_setup_is_called(1);
        $this->then_the_accessed_containers_match([
            null,
        ]);
    }

    /** @test */
    public function returns_the_same_container_store_on_subsequent_accesses() {
        $this->given_the_rox_container_store_is_setup_with_containers($this->productAndCategoryContainers());
        $this->when_the_rox_container_store_is_accessed_for_classes([ProductRoxContainer::class, ProductRoxContainer::class]);
        $this->then_the_accessed_containers_are_of_the_same_instance();
    }

    private function given_the_rox_container_store_is_setup_with_containers(iterable $containers) {
        $this->roxSetup = new StubRoxSetup();
        $this->roxContainerStore = new RoxContainerStore($this->roxSetup, $containers);
    }

    private function productAndCategoryContainers() {
        yield new ProductRoxContainer();
        yield new CategoryRoxContainer();
    }

    private function when_the_rox_container_store_is_accessed_for_classes(array $classes) {
        foreach ($classes as $class) {
            try {
                $this->containerAccess[] = $this->roxContainerStore->get($class);
            } catch (\Throwable $e) {
                $this->containerAccess[] = null;
            }
        }
    }

    private function then_the_accessed_containers_match(array $expectedAccessedContainerClassNamesOrNull) {
        $accessedClassNamesOrNull = array_map(function($res) {
            return $res ? get_class($res) : null;
        }, $this->containerAccess);

        $this->assertEquals($expectedAccessedContainerClassNamesOrNull, $accessedClassNamesOrNull);
    }

    private function then_the_accessed_containers_are_of_the_same_instance() {
        $this->assertSame($this->containerAccess[1], $this->containerAccess[0]);
    }
}
