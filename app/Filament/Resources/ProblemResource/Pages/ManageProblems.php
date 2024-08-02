<?php

namespace App\Filament\Resources\ProblemResource\Pages;

use App\Filament\Resources\ProblemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\MaxWidth;

class ManageProblems extends ManageRecords
{
    protected static string $resource = ProblemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modal()
                ->modalWidth(MaxWidth::ExtraLarge)
                ->slideOver()
                ->stickyModalHeader(),
        ];
    }
}
