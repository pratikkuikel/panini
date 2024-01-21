<?php

namespace Pratikkuikel\Panini;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Pratikkuikel\Panini\Filament\Pages\ResourceGenerator;
use Pratikkuikel\Panini\Filament\Resources\PageManagerResource;
use Pratikkuikel\Panini\Filament\Resources\ResourceGeneratorResource;

class PaniniPlugin implements Plugin
{
    public function getId(): string
    {
        return 'panini';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            PageManagerResource::class
        ]);
        $panel->pages([
            ResourceGenerator::class
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
