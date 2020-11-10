<?php

namespace Krak\SymfonyRox;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class RoxBundle extends Bundle
{
    const TAG_ROX_CONTAINER = 'rollout_rox.container';

    public function getContainerExtension() {
        return new class() extends Extension {
            public function getAlias() {
                return 'rollout_rox';
            }

            public function load(array $configs, ContainerBuilder $container) {
                $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/Resources/etc'));
                $loader->load('services.php');

                $container->registerForAutoconfiguration(RoxContainer::class)->addTag(RoxBundle::TAG_ROX_CONTAINER);
            }
        };
    }
}
