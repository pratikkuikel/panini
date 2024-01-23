<?php

namespace Pratikkuikel\Panini\Filament\Resources\PageManagerResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Pratikkuikel\Panini\Filament\Resources\PageManagerResource;
use Pratikkuikel\Panini\Models\PageManager;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class ListPageManagers extends ListRecords
{
    protected static string $resource = PageManagerResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('upload')
                ->color('success')
                ->icon('heroicon-m-arrow-up-tray')
                ->form([
                    TextInput::make('name')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    FileUpload::make('fields')
                        ->label('Field Metadata')
                        ->required()
                        ->storeFiles(false)
                        ->acceptedFileTypes(['application/json']),
                ])
                ->action(function (array $data): void {
                    $metadataFile = $data['fields'];
                    $json = json_decode(file_get_contents($metadataFile->path()), true);
                    $data['name'] = Str::kebab($data['name']);
                    PageManager::create([
                        'name' => $data['name'],
                        'fields' => $json
                    ]);
                    Notification::make()
                        ->title('Page saved !')
                        ->success()
                        ->send();
                })
        ];
    }
}
