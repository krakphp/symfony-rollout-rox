<?php

namespace Krak\SymfonyRox\Tests\Feature;

use Krak\SymfonyRox\RoxBundle;
use Krak\SymfonyRox\RoxContainerStore;
use Krak\SymfonyRox\RoxSetup;
use Krak\SymfonyRox\Test\StubRoxSetup;
use Krak\SymfonyRox\Tests\Feature\Fixture\ProductRoxContainer;
use Nyholm\BundleTest\BaseBundleTestCase;
use Nyholm\BundleTest\CompilerPass\PublicServicePass;

final class BundleTest extends BaseBundleTestCase
{
    use RoxSetupSteps;

    /** @var ?StubRoxSetup */
    private $roxSetup;
    private $roxContainer;

    protected function getBundleClass() {
        return RoxBundle::class;
    }

    /** @test */
    public function registers_rox_containers_automatically_in_the_container_store() {
        $this->given_the_kernel_is_booted_with_config_files([
            __DIR__ . '/Fixture/rox-container-services.php',
        ]);
        $this->given_the_rox_setup_is_stubbed();
        $this->when_the_rox_container_store_is_accessed_for(ProductRoxContainer::class);
        $this->then_the_total_registered_rox_containers_is(2);
    }

    private function given_the_kernel_is_booted_with_config_files(array $files) {
        $this->addCompilerPass(new PublicServicePass());
        $kernel = $this->createKernel();
        foreach ($files as $file) {
            $kernel->addConfigFile($file);
        }
        $this->bootKernel();
    }

    private function given_the_rox_setup_is_stubbed() {
        $this->roxSetup = new StubRoxSetup();
        $this->getContainer()->set(RoxSetup::class, $this->roxSetup);
    }

    private function when_the_rox_container_store_is_accessed_for(string $className) {
        try {
            $this->roxContainer = $this->getContainer()->get(RoxContainerStore::class)->get($className);
        } catch (\Throwable $e) {}
    }
}
