<?php

namespace App\Filament\Temp\UserResource\Pages;

use App\Filament\Temp\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

//    public function getHeader(): ?View
//    {
//        $data = Actions\CreateAction::make();
//        return view('filament.custom.upload-file', [
//            'data' => $data,
//        ]);
//    }
//
//    public $file = '';
//    public function save(): void
//    {
//        if ($this->file != '') {
//            Excel::import(new UsersImport, $this->file);
//        }
//    }
}
