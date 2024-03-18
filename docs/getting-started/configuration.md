---
title: Configuration
weight: 3
---

## Configuration

to configure the plugin Tartarus, you can pass the configuration to the plugin in `adminPanelProvider`

these all the available configuration, and their defaults values

```php
TartarusPlugin::make()
    ->navigationGroupLabel('Tartarus')
```

## Frontend Configuration

use the file `zeus-tartarus.php`, to customize the frontend, like the prefix,domain, and middleware for each content type.

to publish the configuration:

```bash
php artisan vendor:publish --tag=zeus-tartarus-config
```