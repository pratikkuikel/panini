<?php

namespace Pratikkuikel\Panini\Filament\Resources\PageManagerResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Pratikkuikel\Panini\Filament\Resources\PageManagerResource;

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
