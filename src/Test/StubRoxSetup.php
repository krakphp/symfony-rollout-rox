<?php

namespace Krak\SymfonyRox\Test;

use Krak\SymfonyRox\RoxContainer;
use Krak\SymfonyRox\RoxSetup;

final class StubRoxSetup implements RoxSetup
{
    public $roxContainers = [];
    public $setupCalled = 0;

    public function register(RoxContainer $roxContainer): void {
        $this->roxContainers[] = $roxContainer;
    }

    public function setup(): void {
        $this->setupCalled += 1;
    }
}
