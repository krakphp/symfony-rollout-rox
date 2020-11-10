<?php

namespace Krak\SymfonyRox;

// Marker interface to be used for DI configuration
interface RoxContainer {
    /** Return the namespace to prefix your rox container flags with. Each container must have a unique namespace. */
    public function getNamespace(): string;
}
