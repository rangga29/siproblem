<?php

namespace App\Filament\Resources\SprResource\Pages;

use App\Filament\Resources\SprResource;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSPR extends CreateRecord
{
    protected static string $resource = SprResource::class;

    protected function afterCreate(): void
    {
        $spr = $this->record;
        $user = auth()->user();

        Notification::make()
            ->title('SPR Baru')
            ->icon('heroicon-o-shopping-bag')
            ->body("Ada SPR Baru {$spr->spr_code}.")
            ->actions([
                Action::make('Lihat SPR')
                    ->url(SprResource::getUrl('view', ['record' => $spr]))
            ])
            ->sendToDatabase(User::where('dp_id', $spr->dp_id)
                ->orWhere('dp_id', $user->dp_id)
                ->orWhere('dp_id', $spr->sender->department->id)
                ->get())
            ->broadcast(User::where('dp_id', $spr->dp_id)
                ->orWhere('dp_id', $user->dp_id)
                ->orWhere('dp_id', $spr->sender->department->id)
                ->get());
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
