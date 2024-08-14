<?php

namespace App\Filament\Resources\SprResource\Pages;

use App\Filament\Resources\SprResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSPR extends EditRecord
{
    protected static string $resource = SprResource::class;

    public static function getNavigationLabel(): string
    {
        return 'Ubah Data SPR';
    }

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
