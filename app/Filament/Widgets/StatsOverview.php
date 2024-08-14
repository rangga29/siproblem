<?php

namespace App\Filament\Widgets;

use App\Models\Spr;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static bool $isLazy = false;
    protected static ?string $pollingInterval = '10s';

    public function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        if(auth()->user()->role === 'Administrator') {
            return [
                Stat::make(
                    label: 'Total',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_status', true);
                    })->count()
                ),
                Stat::make(
                    label: 'Terkirim',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Terkirim')
                            ->where('st_status', true);
                    })->count()
                ),
            ];
        } elseif (auth()->user()->department->dp_spr) {
            return [
                Stat::make(
                    label: 'Total',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_status', true);
                    })->where('dp_id', auth()->user()->department->id)->count()
                ),
                Stat::make(
                    label: 'Terkirim',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Terkirim')
                            ->where('st_status', true);
                    })->where('dp_id', auth()->user()->department->id)->count()
                ),
            ];
        } else {
            return [
                Stat::make(
                    label: 'Total',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_status', true);
                    })->whereHas('sender', function ($query) {
                        $query->where('dp_id', auth()->user()->dp_id);
                    })->count()
                ),
                Stat::make(
                    label: 'Terkirim',
                    value: Spr::whereHas('statuses', function ($query) {
                        $query->where('st_name', 'Terkirim')
                            ->where('st_status', true);
                    })->whereHas('sender', function ($query) {
                        $query->where('dp_id', auth()->user()->dp_id);
                    })->count()
                ),
            ];
        }
    }
}
