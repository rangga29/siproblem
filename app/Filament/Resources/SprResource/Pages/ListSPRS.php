<?php

namespace App\Filament\Resources\SprResource\Pages;

use App\Filament\Resources\SprResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSPRS extends ListRecords
{
    protected static string $resource = SprResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Semua'),
            'Terkirim' => Tab::make('Terkirim')
                ->query(fn (Builder $query) => $query->whereHas('statuses', function (Builder $query) {
                    $query->where('st_name', 'Terkirim')->where('st_status', true);
                })),
            'Diperiksa' => Tab::make('Diperiksa')
                ->query(fn (Builder $query) => $query->whereHas('statuses', function (Builder $query) {
                    $query->where('st_name', 'Diperiksa')->where('st_status', true);
                })),
            'Diproses' => Tab::make('Diproses')
                ->query(fn (Builder $query) => $query->whereHas('statuses', function (Builder $query) {
                    $query->where('st_name', 'Diproses')->where('st_status', true);
                })),
            'Ditolak' => Tab::make('Ditolak')
                ->query(fn (Builder $query) => $query->whereHas('statuses', function (Builder $query) {
                    $query->where('st_name', 'Ditolak')->where('st_status', true);
                })),
            'Dibatalkan' => Tab::make('Dibatalkan')
                ->query(fn (Builder $query) => $query->whereHas('statuses', function (Builder $query) {
                    $query->where('st_name', 'Dibatalkan')->where('st_status', true);
                })),
            'Selesai' => Tab::make('Selesai')
                ->query(fn (Builder $query) => $query->whereHas('statuses', function (Builder $query) {
                    $query->where('st_name', 'Selesai')->where('st_status', true);
                })),
        ];
    }
}
