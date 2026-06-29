<?php

namespace KennethTomagan\FilamentThemes\Http\Middleware;

use Closure;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Http\Request;
use KennethTomagan\FilamentThemes\Contracts\CanModifyPanelConfig;
use KennethTomagan\FilamentThemes\Contracts\HasOnlyDarkMode;
use KennethTomagan\FilamentThemes\Contracts\HasOnlyLightMode;
use KennethTomagan\FilamentThemes\Filament\Pages\Themes as ThemesPage;
use KennethTomagan\FilamentThemes\Themes;
use KennethTomagan\FilamentThemes\Themes\DefaultTheme;
use KennethTomagan\FilamentThemes\Themes\Dracula;
use KennethTomagan\FilamentThemes\Themes\Nord;
use KennethTomagan\FilamentThemes\Themes\Sunset;
use KennethTomagan\FilamentThemes\ThemesPlugin;
use Symfony\Component\HttpFoundation\Response;

class SetTheme
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Themes $themes */
        $themes = app(Themes::class);
        $panel = Filament::getCurrentPanel();

        if (! $panel->hasPlugin('themes')) {
            return $next($request);
        }

        /**
         * Important for Laravel Octane!
         *
         * Check if item already exists before adding it
         * to the menu items.
         */
        if (! isset($panel->getUserMenuItems()['themes'])) {
            $panel->userMenuItems(
                ThemesPlugin::canView() ?
                    [
                        Action::make('themes')
                            ->label(fn () => __('themes::themes.themes'))
                            ->icon(config('themes.icon'))
                            ->url(ThemesPage::getUrl()),
                    ] : []
            );
        }

        FilamentColor::register($themes->getCurrentThemeColor());

        $currentTheme = $themes->getCurrentTheme();
        FilamentAsset::register([
            match (get_class($currentTheme)) {
                Dracula::class => Css::make(Dracula::getName(), Dracula::getPath()),
                Nord::class => Css::make(Nord::getName(), Nord::getPath()),
                Sunset::class => Css::make(Sunset::getName(), Sunset::getPath()),
                default => Css::make(DefaultTheme::getName(), DefaultTheme::getPath()),
            },
        ], 'kennethtomagan/filament-themes');

        if (! $panel->hasDarkModeForced()) {
            $panel->darkMode(! $currentTheme instanceof HasOnlyLightMode, $currentTheme instanceof HasOnlyDarkMode);
        }

        if ($currentTheme instanceof CanModifyPanelConfig) {
            $currentTheme->modifyPanelConfig($panel);
        }

        return $next($request);
    }
}
