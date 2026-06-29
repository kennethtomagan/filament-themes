<?php

use KennethTomagan\FilamentThemes\ThemesPlugin;

// The service provider binds ThemesPlugin as a singleton in production. Reset that
// singleton before each test so the mutable canView callback set in one test does
// not leak into another under random execution order.
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
