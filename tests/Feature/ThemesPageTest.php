<?php

use KennethTomagan\FilamentThemes\Filament\Pages\Themes;

it('declares a navigation icon compatible with Filament v4', function () {
    $property = new ReflectionProperty(Themes::class, 'navigationIcon');
    $type = (string) $property->getType();

    expect($type)->toContain('BackedEnum');
});

it('exposes the registered themes to the view', function () {
    $page = new Themes();

    expect($page->getThemes()->keys()->all())
        ->toContain('default', 'dracula', 'nord', 'sunset');
});
