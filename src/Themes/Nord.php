<?php

namespace KennethTomagan\FilamentThemes\Themes;

use Filament\Panel;
use Filament\Support\Colors\Color;
use KennethTomagan\FilamentThemes\Contracts\CanModifyPanelConfig;
use KennethTomagan\FilamentThemes\Contracts\Theme;

class Nord implements CanModifyPanelConfig, Theme
{
    public static function getName(): string
    {
        return 'nord';
    }

    public static function getPath(): string
    {
        return __DIR__ . '/../../resources/dist/nord.css';
    }

    public function getThemeColor(): array
    {
        return [
            'primary' => Color::hex('#8FBCBB'),
            'secondary' => Color::hex('#2E3440'),
            'info' => Color::hex('#5E81AC'),
            'success' => Color::hex('#A3BE8C'),
            'warning' => Color::hex('#D08770'),
            'danger' => Color::hex('#BF616A'),
        ];
    }

    public function modifyPanelConfig(Panel $panel): Panel
    {
        return $panel
            ->topNavigation()
            ->sidebarCollapsibleOnDesktop(false)
            ->renderHook('panels::page.start', fn () => view('themes::filament.hooks.tenant-menu'));
    }
}
