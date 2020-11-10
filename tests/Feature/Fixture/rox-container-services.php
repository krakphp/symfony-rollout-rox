<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Krak\SymfonyRox\Tests\Feature\Fixture\CategoryRoxContainer;
use Krak\SymfonyRox\Tests\Feature\Fixture\ProductRoxContainer;

return static function(ContainerConfigurator $configurator) {
    $configurator
    ->services()
        ->defaults()->autoconfigure()
        ->set(ProductRoxContainer::class)
        ->set(CategoryRoxContainer::class)
    ;
};
