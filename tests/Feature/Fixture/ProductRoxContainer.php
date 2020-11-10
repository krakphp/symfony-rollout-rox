<?php

namespace Krak\SymfonyRox\Tests\Feature\Fixture;

use Krak\SymfonyRox\RoxContainer;
use Rox\Server\Flags\RoxFlag;

final class ProductRoxContainer implements RoxContainer
{
    public $showOOS;

    public function __construct() {
        $this->showOOS = new RoxFlag(false);
    }

    public function getNamespace(): string {
        return 'product';
    }
}
