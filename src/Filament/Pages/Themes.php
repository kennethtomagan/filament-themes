<?php

namespace KennethTomagan\FilamentThemes\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use KennethTomagan\FilamentThemes\ThemesPlugin;

class Themes extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $title = 'Appearance';

    public function getTitle(): string | Htmlable
    {
        return __('themes::themes.appearance');
    }

    protected string $view = 'themes::filament.pages.themes';

    public function mount(): void
    {
        abort_unless(ThemesPlugin::canView(), 403);
    }

    public function getThemes()
    {
        return app(\KennethTomagan\FilamentThemes\Themes::class)->getThemes();
    }

    public function getCurrentTheme()
    {
        return app(\KennethTomagan\FilamentThemes\Themes::class)->getCurrentTheme();
    }

    public function getColor()
    {
        if (config('themes.mode') === 'global') {
            return cache('theme_color');
        }

        return Filament::auth()->user()->theme_color;
    }

    public function getColors()
    {
        return Arr::except(Color::all(), ['gray', 'zinc', 'neutral', 'stone']);
    }

    public function setColor(string $color)
    {
        if (config('themes.mode') === 'global') {
            cache(['theme_color' => $color]);
        } else {
            $user = Filament::auth()->user();
            $user->theme_color = $color;
            $user->save();
        }

        Notification::make()
            ->title(__('themes::themes.primary_color_set') . ' ' . $color . '.')
            ->success()
            ->send();

        return $this->redirect(self::getUrl());
    }

    public function setTheme(string $theme)
    {
        if (config('themes.mode') === 'global') {
            cache(['theme' => $theme]);
        } else {
            $user = Filament::auth()->user();
            $user->theme = $theme;
            $user->save();
        }

        Notification::make()
            ->title(__('themes::themes.theme_set_to') . ' ' . $theme . '.')
            ->success()
            ->send();

        return $this->redirect(self::getUrl());
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getFooter(): ?View
    {
        return view('themes::filament.pages.themes-footer');
    }
}
