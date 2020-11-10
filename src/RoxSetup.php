<?php

namespace Krak\SymfonyRox;

/**
 * Simple interface needed to register and setup. If you have any custom needs for rox configuration/setup, implement
 * your own implementation.
 */
interface RoxSetup
{
    /** Expected to call Rox::register at some point */
    public function register(RoxContainer $roxContainer): void;
    /** Expected to call Rox::setup at some point */
    public function setup(): void;
}
