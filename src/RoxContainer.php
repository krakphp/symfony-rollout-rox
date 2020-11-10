<?php

namespace Krak\SymfonyRox;

// Marker interface to be used for DI configuration
abstract class RoxContainer
{
    public function getNamespace(): string {
        return "";
    }
}
