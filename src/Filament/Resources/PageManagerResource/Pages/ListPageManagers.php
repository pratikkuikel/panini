<?php

namespace Pratikkuikel\Panini\Filament\Resources\PageManagerResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Pratikkuikel\Panini\Filament\Resources\PageManagerResource;

class ListPageManagers extends ListRecords
{
    protected static string $resource = PageManagerResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
