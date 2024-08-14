<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Imports\UsersImport;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

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

//    public function getHeader(): ?View
//    {
//        $data = CreateAction::make()
//            ->modal()
//            ->modalWidth(MaxWidth::ExtraLarge)
//            ->slideOver()
//            ->stickyModalHeader();
//        return view('filament.custom.upload-file', [
//            'data' => $data,
//        ]);
//    }
//
//    public $file = '';
//    public function save(): void
//    {
//        if($this->file != '') {
//            Excel::import(new UsersImport(), $this->file);
//        }
//    }
}
