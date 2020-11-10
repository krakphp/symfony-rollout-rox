<?php

namespace Krak\SymfonyRox;

use Rox\Server\Rox;
use Rox\Server\RoxOptions;

/** Reference the Rox global static methods and use the default configuration provided by rox. */
final class GlobalDefaultRoxSetup implements RoxSetup
{
    private $apiKey;
    private $roxOptions;

    public function __construct(string $apiKey, ?RoxOptions $roxOptions = null) {
        $this->apiKey = $apiKey;
        $this->roxOptions = $roxOptions;
    }

    public function register(RoxContainer $roxContainer): void {
        Rox::register($roxContainer->getNamespace(), $roxContainer);
    }

    public function setup(): void {
        Rox::setup($this->apiKey, $this->roxOptions);
    }
}
