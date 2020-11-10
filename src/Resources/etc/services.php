<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Krak\SymfonyRox\GlobalDefaultRoxSetup;
use Krak\SymfonyRox\RoxBundle;
use Krak\SymfonyRox\RoxContainerStore;
use Krak\SymfonyRox\RoxSetup;

return static function(ContainerConfigurator $configurator) {
    $configurator->parameters()
        ->set('rollout_rox_app_env_key', '%env(ROLLOUT_ROX_APP_ENV_KEY)%')
    ;

    $configurator->services()
        ->defaults()
            ->private()->autowire()->autoconfigure()
        ->set(RoxSetup::class, GlobalDefaultRoxSetup::class)
            ->args(['%rollout_rox_app_env_key%', null])
        ->set(RoxContainerStore::class)
            ->args([ref(RoxSetup::class), tagged_iterator(RoxBundle::TAG_ROX_CONTAINER)])
    ;
};
