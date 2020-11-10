<?php

namespace Krak\SymfonyRox;

final class RoxContainerStore
{
    private $roxSetup;
    private $roxContainers;
    private $roxContainerMap = [];
    private $hasInit = false;

    /** @param RoxContainer[] $roxContainers */
    public function __construct(RoxSetup $roxSetup, iterable $roxContainers) {
        $this->roxSetup = $roxSetup;
        $this->roxContainers = $roxContainers;
    }

    /** @psalm-var interface-string<RoxContainer> */
    public function get(string $className): object {
        $this->initRox();
        if (!isset($this->roxContainerMap[$className])) {
            throw new \RuntimeException("Rox container not found with class name: $className");
        }

        return $this->roxContainerMap[$className];
    }

    private function initRox(): void {
        if ($this->hasInit) {
            return;
        }

        $this->hasInit = true;
        $this->roxContainerMap = self::reduceRoxContainersToMap($this->roxContainers);
        foreach ($this->roxContainerMap as $container) {
            $this->roxSetup->register($container);
        }
        $this->roxSetup->setup();
    }

    /** @return RoxContainer[] */
    private static function reduceRoxContainersToMap(iterable $roxContainers): array {
        $acc = [];
        foreach ($roxContainers as $container) {
            $acc[get_class($container)] = $container;
        }
        return $acc;
    }
}
