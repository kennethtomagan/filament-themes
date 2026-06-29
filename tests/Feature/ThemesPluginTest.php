<?php

use KennethTomagan\FilamentThemes\ThemesPlugin;

beforeEach(fn () => app()->singleton(ThemesPlugin::class));

it('has the stable plugin id', function () {
    expect(ThemesPlugin::make()->getId())->toBe('themes');
});

it('allows viewing the themes page by default', function () {
    expect(ThemesPlugin::canView())->toBeTrue();
});

it('honours a custom canView callback', function () {
    ThemesPlugin::make()->canViewThemesPage(fn () => false);

    expect(ThemesPlugin::canView())->toBeFalse();
});
