<?php

namespace KennethTomagan\FilamentThemes\Themes;

use Filament\Support\Colors\Color;
use Illuminate\Support\Arr;
use KennethTomagan\FilamentThemes\Contracts\HasChangeableColor;
use KennethTomagan\FilamentThemes\Contracts\Theme;

class DefaultTheme implements HasChangeableColor, Theme
{
    public static function getName(): string
    {
        return 'default';
    }

    public static function getPath(): string
    {
        return __DIR__ . '/../../resources/dist/default.css';
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
