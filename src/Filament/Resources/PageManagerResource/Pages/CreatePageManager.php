<?php

namespace Pratikkuikel\Panini\Filament\Resources\PageManagerResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Pratikkuikel\Panini\Filament\Resources\PageManagerResource;
use Illuminate\Support\Str;

class CreatePageManager extends CreateRecord
{
    protected static string $resource = PageManagerResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = Str::kebab($data['name']);

        return $data;
    }
}
