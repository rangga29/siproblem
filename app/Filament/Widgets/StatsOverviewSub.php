<?php

namespace App\Filament\Widgets;

use App\Models\Spr;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewSub extends BaseWidget
{
    protected static ?int $sort = 3;
    protected static bool $isLazy = false;
    protected static ?string $pollingInterval = '10s';

    public function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {
        if(auth()->user()->role === 'Administrator') {
            return [
                Stat::make(
                    label: 'Diproses',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Diproses')
                            ->where('st_status', true);
                    })->count()
                ),
                Stat::make(
                    label: 'Dibatalkan',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Dibatalkan')
                            ->where('st_status', true);
                    })->count()
                ),
                Stat::make(
                    label: 'Selesai',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Selesai')
                            ->where('st_status', true);
                    })->count()
                ),
            ];
        } elseif (auth()->user()->department->dp_spr) {
            return [
                Stat::make(
                    label: 'Diproses',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Diproses')
                            ->where('st_status', true);
                    })->where('dp_id', auth()->user()->department->id)->count()
                ),
                Stat::make(
                    label: 'Dibatalkan',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Dibatalkan')
                            ->where('st_status', true);
                    })->where('dp_id', auth()->user()->department->id)->count()
                ),
                Stat::make(
                    label: 'Selesai',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Selesai')
                            ->where('st_status', true);
                    })->where('dp_id', auth()->user()->department->id)->count()
                ),
            ];
        } else {
            return [
                Stat::make(
                    label: 'Diproses',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Diproses')
                            ->where('st_status', true);
                    })->whereHas('sender', function ($query) {
                        $query->where('dp_id', auth()->user()->dp_id);
                    })->count()
                ),
                Stat::make(
                    label: 'Dibatalkan',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Dibatalkan')
                            ->where('st_status', true);
                    })->whereHas('sender', function ($query) {
                        $query->where('dp_id', auth()->user()->dp_id);
                    })->count()
                ),
                Stat::make(
                    label: 'Selesai',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Selesai')
                            ->where('st_status', true);
                    })->whereHas('sender', function ($query) {
                        $query->where('dp_id', auth()->user()->dp_id);
                    })->count()
                ),
            ];
        }
    }
}
