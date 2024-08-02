<?php

namespace App\Filament\Temp\ProblemResource\Pages;

use App\Filament\Temp\ProblemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProblem extends CreateRecord
{
    protected static string $resource = ProblemResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
