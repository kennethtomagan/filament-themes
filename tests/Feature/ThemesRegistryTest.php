<?php

use KennethTomagan\FilamentThemes\Contracts\Theme;
use KennethTomagan\FilamentThemes\Themes;
use KennethTomagan\FilamentThemes\Themes\DefaultTheme;
use KennethTomagan\FilamentThemes\Themes\Nord;

it('registers the four built-in themes by name', function () {
    $registry = new Themes;

    expect($registry->getThemes()->keys()->all())
        ->toBe(['default', 'dracula', 'nord', 'sunset']);
});

it('makes a theme instance by name', function () {
    $registry = new Themes;

    expect($registry->make('nord'))->toBeInstanceOf(Nord::class)
        ->and($registry->make('default'))->toBeInstanceOf(DefaultTheme::class);
});

it('falls back to the first theme for an unknown name', function () {
    $registry = new Themes;

    expect($registry->make('does-not-exist'))->toBeInstanceOf(Theme::class);
});

it('merges additional registered themes', function () {
    $registry = new Themes;
    $registry->register(['custom' => DefaultTheme::class]);

    expect($registry->getThemes()->keys()->all())->toContain('custom');
});

it('throws when registering an empty theme array', function () {
    (new Themes)->register([]);
})->throws(InvalidArgumentException::class);
