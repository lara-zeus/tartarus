---
title: Setup
weight: 2
---

## Setup Tartarus

to install Tartarus, use the command:

`php artisan tartarus:install`

The install command will publish the migrations.

## Register Tartarus with Filament:

To set up the plugin with filament, you need to add it to your panel provider; The default one is `adminPanelProvider`

```php
->plugins([
    TartarusPlugin::make(),
])
```
