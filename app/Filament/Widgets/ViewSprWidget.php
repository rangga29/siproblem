<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ViewSprWidget extends Widget
{
    protected static ?int $sort = 4;
    protected static bool $isLazy = false;

    protected static string $view = 'filament.widgets.view-spr-widget';
}
