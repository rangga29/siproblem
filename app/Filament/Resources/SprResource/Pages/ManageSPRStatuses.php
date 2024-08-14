<?php

namespace App\Filament\Resources\SprResource\Pages;

use App\Filament\Resources\SprResource;
use App\Models\Status;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function auth;

class ManageSPRStatuses extends ManageRelatedRecords
{
    protected static string $resource = SprResource::class;

    protected static string $relationship = 'statuses';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public function getTitle(): string
    {
        return "Histori Status SPR";
    }

    public static function getNavigationLabel(): string
    {
        return 'Histori Status SPR';
    }

    protected function getActions(): array
    {
        return [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(auth()->user()->id),
                Hidden::make('st_ucode')
                    ->default(Str::random(20)),
                Select::make('st_name')
                    ->label('Status Baru')
                    ->options([
                        'Terkirim' => 'Terkirim',
                        'Diproses' => 'Diproses',
                        'Dibatalkan' => 'Dibatalkan',
                        'Selesai' => 'Selesai',
                    ])
                    ->required()
                    ->columnSpan('full'),
                MarkdownEditor::make('st_description')
                    ->label('Deskripsi')
                    ->columnSpan('full'),
                FileUpload::make('st_images')
                    ->label('Upload Gambar')
                    ->multiple()
                    ->disk('public')
                    ->directory('spr')
                    ->maxFiles(5)
                    ->reorderable()
                    ->columnSpan('full'),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                TextEntry::make('user.name')
                    ->label('Nama'),
                TextEntry::make('st_name')
                    ->label('Status'),
                TextEntry::make('st_description')
                    ->label('Deskripsi')
                    ->prose(),
                ImageEntry::make('st_images')
                    ->hiddenLabel()
                    ->size(260)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->state(
                    static function (HasTable $livewire, \stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration + ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1))
                        );
                    }
                ),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('l, d F Y H:i:s')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Nama'),
                TextColumn::make('st_name')
                    ->label('Status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn ($record) => $record->st_status == true && $record->user_id == auth()->user()->id),
            ])
            ->defaultSort('created_at', 'DESC');
    }
}
