<?php

namespace Krak\SymfonyRox\Tests\Feature\Fixture;

use Krak\SymfonyRox\RoxContainer;
use Rox\Server\Flags\RoxVariant;

final class CategoryRoxContainer implements RoxContainer
{
    public $backgroundColor;

    public function __construct() {
        $this->backgroundColor = new RoxVariant('red');
    }

    public function getNamespace(): string {
        return 'category';
    }
}
