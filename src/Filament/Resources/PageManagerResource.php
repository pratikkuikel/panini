<?php

namespace Pratikkuikel\Panini\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Pratikkuikel\Panini\Filament\Resources\PageManagerResource\Pages;
use Pratikkuikel\Panini\Models\PageManager;

class PageManagerResource extends Resource
{
    protected static ?string $model = PageManager::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageManagers::route('/'),
            'create' => Pages\CreatePageManager::route('/create'),
            'edit' => Pages\EditPageManager::route('/{record}/edit'),
        ];
    }
}
