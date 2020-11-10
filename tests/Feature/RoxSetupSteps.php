<?php

namespace Krak\SymfonyRox\Tests\Feature;

use Krak\SymfonyRox\Test\StubRoxSetup;

trait RoxSetupSteps
{
    /** @var StubRoxSetup */
    private $roxSetup;

    private function then_the_total_registered_rox_containers_is(int $total) {
        $this->assertCount($total, $this->roxSetup->roxContainers);
    }

    private function then_rox_setup_is_called(int $times) {
        $this->assertEquals($times, $this->roxSetup->setupCalled);
    }
}
