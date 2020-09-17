# Symfony Rollout Rox Integration

Symfony bundle integration with [CloudBees Feature Flags (Rox by Rollout) php sdk](https://github.com/rollout/rox-php).

## Installation

Install with composer at `krak/symfony-rollout-rox`.

If symfony's composer install doesn't automatically register the bundle, you can do so manually:

```php
<?php

return [
  //...
  Krak\SymfonyRox\RoxBundle::class => ['all' => true],
];
```

## Usage

### Configuring the App Environment Key

**Via ENV**

Just setting `ROLLOUT_ROX_APP_ENV_KEY` will automatically register the configuration for you.

**Via Config**

```yaml
rollout_rox:
  app_env_key: 'key goes here'
```

### Registering Containers

The Rox php library works by registering container objects with public properties that contain the default flags/variants for an experiment. The Rox system will automatically register your flags/variants with the rollout api/admin interface.

To create and register a container, you can implement the RoxContainer interface.

```php
<?php

namespace App\FeatureFlags;

use Krak\SymfonyRox\RoxContainer;
use Rox\Server\Flags\RoxFlag;

final class ProductContainer implements RoxContainer
{
    public $showQtyOnPDP;

    public function __construct() {
        $this->showQtyOnPDP = new RoxFlag(false);
    }
    
    // the namespace controls the prefix used in the rollout admin
    // when displaying your flags or variants.
    public function getNamespace(): string {
        return 'product';
    }
}
```

Then to use that container in a service, you'll need to access it via the ContainerStore.

```php
<?php

namespace App\Service;

use Krak\SymfonyRox\RoxContainerStore;

final class BuildPDPPrices
{
    private $flagsStore;

    public function __construct(RoxContainerStore $flagsStore) {
        $this->flagsStore = $flagsStore;
    }

    public function __invoke(string $productId): array {
        $container = $this->flagsStore->get(\App\FeatureFlags\ProductContainer::class);
        return [
            'qty' => $container->showQtyOnPDP->isEnabled() ? 1 : null,
            'price' => 100,
        ];
    }
}
```

The ContainerStore is needed to lazily initialize the Rox system. Not all requests will need to use a feature flag, so the bundle doesn't initialize until a container is accessed from the store. 
