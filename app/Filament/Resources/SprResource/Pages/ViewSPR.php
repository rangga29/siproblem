<?php

namespace App\Filament\Resources\SprResource\Pages;

use App\Filament\Resources\SprResource;
use App\Models\Spr;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewSPR extends ViewRecord
{
    protected static string $resource = SprResource::class;

    public static function getNavigationLabel(): string
    {
        return 'Lihat Data SPR';
    }

    protected function getActions(): array
    {
        return [];
    }
}
