<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SPRResource\Pages;
use App\Filament\Resources\SprResource\Pages\ManageSPRStatuses;
use App\Filament\Resources\SprResource\Pages\ViewSPR;
use App\Models\Department;
use App\Models\Problem;
use App\Models\Spr;
use App\Models\Status;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class SprResource extends Resource
{
    protected static ?string $model = Spr::class;

    protected static ?string $label = 'Data SPR';
    protected static ?string $navigationLabel = 'Data SPR';
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?int $navigationSort = 2;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Hidden::make('sender_id')
                    ->default(auth()->user()->id),
                Forms\Components\TextInput::make('spr_title')
                    ->label('Judul SPR')
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\Hidden::make('spr_ucode')
                    ->default(Str::random(20))
                    ->unique(Spr::class, 'spr_ucode', ignoreRecord: true),
                Forms\Components\Hidden::make('spr_code'),
                Forms\Components\Select::make('dp_id')
                    ->label('Nama Unit')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->options(Department::where('dp_spr', true)->orderBy('dp_name')->pluck('dp_name', 'id'))
                    ->afterStateUpdated(fn (Set $set) => $set('pr_id', null)),
                Forms\Components\Select::make('pr_id')
                    ->label('Nama Permasalahan')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->options(fn (Forms\Get $get): \Illuminate\Support\Collection => Problem::query()
                        ->where('dp_id', $get('dp_id'))
                        ->orderBy('pr_name')
                        ->pluck('pr_name', 'id')),
                Forms\Components\MarkdownEditor::make('spr_description')
                    ->label('Deskripsi')
                    ->columnSpan('full'),
                Forms\Components\FileUpload::make('spr_images')
                    ->label('Upload Gambar')
                    ->multiple()
                    ->disk('public')
                    ->directory('spr')
                    ->maxFiles(5)
                    ->reorderable()
                    ->columnSpan('full'),
            ])->columns(2)
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['sender.department', 'statuses' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }]);
    }

    public static function getColumns(): array
    {
        $user = auth()->user();

        $columns = [
            TextColumn::make('No')->state(
                static function (Tables\Contracts\HasTable $livewire, \stdClass $rowLoop): string {
                    return (string) (
                        $rowLoop->iteration + ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1))
                    );
                }
            ),
            TextColumn::make('spr_code')
                ->label('Kode')
                ->searchable()
                ->sortable(),
            TextColumn::make('spr_title')
                ->label('Judul')
                ->searchable()
                ->sortable()
                ->limit(20),
            TextColumn::make('sender.name')
                ->label('Pelapor')
                ->searchable(['sender.name', 'sender.department.dp_name'])
                ->sortable(['sender.name', 'sender.department.dp_name'])
                ->formatStateUsing(function ($record) {
                    $sender = $record->sender;
                    $senderName = $sender ? $sender->name : '';
                    $departmentName = $sender && $sender->department ? $sender->department->dp_name : '';
                    return "{$senderName} - {$departmentName}";
                }),
            TextColumn::make('problem.pr_name')
                ->label('Permasalahan')
                ->searchable(['problem.pr_name', 'problem.department.dp_name'])
                ->sortable(['problem.pr_name', 'problem.department.dp_name'])
                ->formatStateUsing(function ($record) {
                    $problem = $record->problem;
                    $problemName = $problem ? $problem->pr_name : '';
                    $departmentName = $problem && $problem->department ? $problem->department->dp_name : '';
                    return "{$departmentName} - {$problemName}";
                }),
            TextColumn::make('statuses.st_name')
                ->label('Status')
                ->formatStateUsing(function ($record) {
                    $latestStatus = Status::where('spr_id', $record->id)
                        ->where('st_status', true)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    return $latestStatus ? $latestStatus->st_name : 'N/A';
                })
        ];

        if ($user->role === 'Administrator') {
            $columns[] = TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true);

            $columns[] = TextColumn::make('updated_at')
                ->label('Updated At')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true);
        }

        return $columns;
    }

    public static function getActions(): array
    {
        $user = auth()->user();

        return [
            Action::make('addStatus')
                ->label('Status & Komentar')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->action(function (Spr $record, array $data) {
                    Status::where('spr_id', $record?->id)
                        ->where('st_status', true)
                        ->update(['st_status' => false]);
                    Status::create([
                        'spr_id' => $record->id,
                        'user_id' => $data['user_id'],
                        'st_ucode' => $data['st_ucode'],
                        'st_name' => $data['st_name'],
                        'st_status' => true,
                        'st_description' => $data['st_description'],
                        'st_image' => $data['st_images'],
                    ]);
                })
                ->form([
                    Forms\Components\Hidden::make('user_id')
                        ->default(auth()->user()->id),
                    Forms\Components\Hidden::make('st_ucode')
                        ->default(Str::random(20)),
                    Forms\Components\Placeholder::make('old_st_name')
                        ->label('Status Lama')
                        ->content(fn ($record) => Status::where('spr_id', $record?->id)
                            ->where('st_status', true)
                            ->orderByDesc('created_at')->first()->st_name ?? 'N/A'),
                    Forms\Components\Hidden::make('st_name')
                        ->default(fn (Spr $record) => Status::where('spr_id', $record?->id)->where('st_status', true)->first()->st_name)
                        ->visible(fn (Spr $record) => $user->department && $record->sender->department->id === $user->department->id),
                    Forms\Components\Select::make('st_name')
                        ->label('Status Baru')
                        ->options([
                            'Terkirim' => 'Terkirim',
                            'Diproses' => 'Diproses',
                            'Dibatalkan' => 'Dibatalkan',
                            'Selesai' => 'Selesai',
                        ])
                        ->required()
                        ->visible(fn (Spr $record) => $user->role === 'Administrator' || $user->department && ($user->department->dp_spr)),
                    Forms\Components\MarkdownEditor::make('st_description')
                        ->label('Deskripsi')
                        ->columnSpan('full'),
                    Forms\Components\FileUpload::make('st_images')
                        ->label('Upload Gambar')
                        ->multiple()
                        ->disk('public')
                        ->directory('spr')
                        ->maxFiles(5)
                        ->reorderable()
                        ->columnSpan('full'),
                ])
                ->modalHeading('Ubah Status')
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->visible(function (Spr $record) {
                    $user = auth()->user();
                    $hasPermission = $user->role === 'Administrator' ||
                        ($user->department && ($user->department->dp_spr || $record->sender->department->id === $user->department->id));
                    $latestStatus = Status::where('spr_id', $record->id)
                        ->where('st_status', true)
                        ->orderByDesc('created_at')
                        ->first();
                    return $hasPermission && (!$latestStatus || $latestStatus->st_name !== 'Selesai');
                })
                ->after(function (Spr $record) {
                    $user = auth()->user();
                    Notification::make()
                        ->title('Status Baru')
                        ->icon('heroicon-o-chat-bubble-left-ellipsis')
                        ->body("Status Baru untuk SPR #{$record->spr_code}.")
                        ->actions([
                            \Filament\Notifications\Actions\Action::make('Lihat Status')
                                ->url(SprResource::getUrl('statuses', ['record' => $record]))
                        ])
                        ->sendToDatabase(User::where('dp_id', $record->dp_id)
                            ->orWhere('dp_id', $user->dp_id)
                            ->orWhere('dp_id', $record->sender->department->id)
                            ->get())
                        ->broadcast(User::where('dp_id', $record->dp_id)
                            ->orWhere('dp_id', $user->dp_id)
                            ->orWhere('dp_id', $record->sender->department->id)
                            ->get());
                })
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getColumns())
            ->actions(self::getActions())
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();
                if ($user->role === 'Administrator') {
                    return $query;
                }
                if (!$user->department || !$user->department->dp_spr) {
                    return $query->whereHas('sender', function ($subQuery) use ($user) {
                        $subQuery->where('dp_id', $user->dp_id);
                    });
                }
                return $query->where('dp_id', $user->dp_id);
            })
            ->groups([
                Tables\Grouping\Group::make('created_at')
                    ->label('Tanggal')
                    ->date()
                    ->collapsible(),
            ])
            ->recordAction(null);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make()->schema([
                TextEntry::make('spr_title')
                    ->label('Judul')
                    ->columnSpan('2'),
                TextEntry::make('statuses.st_name')
                    ->label('Status Terakhir')
                    ->formatStateUsing(fn($record) => $record->statuses->firstWhere('st_status', true)->orderBy('created_at','DESC')->first()->st_name ?? 'N/A')
                    ->columnSpan(1),
                TextEntry::make('problem.pr_name')
                    ->label('Modul Permasalahan')
                    ->formatStateUsing(function ($record) {
                        $problem = $record->problem;
                        $problemName = $problem ? $problem->pr_name : '';
                        $departmentName = $problem && $problem->department ? $problem->department->dp_name : '';
                        return "{$problemName} - {$departmentName}";
                    })->columnSpan(2),
                TextEntry::make('sender.name')
                    ->label('Pengirim')
                    ->formatStateUsing(function ($record) {
                        $sender = $record->sender;
                        $senderName = $sender ? $sender->name : '';
                        $departmentName = $sender && $sender->department ? $sender->department->dp_name : '';
                        return "{$senderName} - {$departmentName}";
                    })->columnSpan(2),
                TextEntry::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->columnSpan('2'),
                TextEntry::make('updated_at')
                    ->label('Tanggal Terakhir Diubah')
                    ->columnSpan('2'),
            ])->columns(['md' => 4]),
            Section::make('Deskripsi')->schema([
                TextEntry::make('spr_description')
                    ->prose()
                    ->markdown()
                    ->hiddenLabel(),
            ])->collapsible(),
            Section::make('Gambar')->schema([
                ImageEntry::make('spr_images')
                    ->hiddenLabel()
                    ->size(260)
            ])->collapsible(),
        ]);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewSPR::class,
            ManageSPRStatuses::class
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSPRS::route('/'),
            'create' => Pages\CreateSPR::route('/create'),
            'statuses' => Pages\ManageSPRStatuses::route('/{record}/statuses'),
            'edit' => Pages\EditSPR::route('/{record}/edit'),
            'view' => Pages\ViewSPR::route('/{record}'),
        ];
    }
}
