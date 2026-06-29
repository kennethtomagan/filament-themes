<?php

namespace KennethTomagan\FilamentThemes\Themes;

use Filament\Support\Colors\Color;
use Illuminate\Support\Arr;
use KennethTomagan\FilamentThemes\Contracts\HasChangeableColor;
use KennethTomagan\FilamentThemes\Contracts\Theme;

class Sunset implements HasChangeableColor, Theme
{
    public static function getName(): string
    {
        return 'sunset';
    }

    public static function getPath(): string
    {
        return __DIR__ . '/../../resources/dist/sunset.css';
    }

    public function getThemeColor(): array
    {
        return Arr::except(Color::all(), ['gray', 'zinc', 'neutral', 'stone']);
    }

    public function getPrimaryColor(): array
    {
        return ['primary' => $this->getThemeColor()['blue']];
    }
}
