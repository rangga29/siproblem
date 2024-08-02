<?php

namespace App\Filament\Temp\ProblemResource\Pages;

use App\Filament\Temp\ProblemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProblem extends EditRecord
{
    protected static string $resource = ProblemResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
