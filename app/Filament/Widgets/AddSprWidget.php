<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AddSprWidget extends Widget
{
    protected static ?int $sort = 5;
    protected static bool $isLazy = false;

    protected static string $view = 'filament.widgets.add-spr-widget';
}
