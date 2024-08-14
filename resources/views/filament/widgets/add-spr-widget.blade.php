@php
    use App\Filament\Resources\SprResource;
    $createUrl = SprResource::getUrl('create');
@endphp

<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1">
                <h1 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white" >
                    {{ __('Buat Data SPR Baru') }}
                </h1>
            </div>

            <div class="flex flex-col items-end gap-y-1">
                <x-filament::link
                    color="gray"
                    href="{{ $createUrl }}"
                    icon="heroicon-o-plus-circle"
                    icon-alias="panels::filament.widgets.add-spr-widget"
                    class="inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md shadow-sm text-white hover:bg-primary-700 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                    {{ __('Buat Data') }}
                </x-filament::link>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
