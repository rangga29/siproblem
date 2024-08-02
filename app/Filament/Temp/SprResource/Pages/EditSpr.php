<?php

namespace App\Filament\Temp\SprResource\Pages;

use App\Filament\Temp\SprResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpr extends EditRecord
{
    protected static string $resource = SprResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
