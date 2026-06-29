<?php

namespace KennethTomagan\FilamentThemes\Contracts;

interface Theme
{
    public static function getName(): string;

    public static function getPath(): string;

    public function getThemeColor(): array;
}
