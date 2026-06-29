<?php

namespace KennethTomagan\FilamentThemes\Contracts;

use Filament\Panel;

interface CanModifyPanelConfig
{
    public function modifyPanelConfig(Panel $panel): Panel;
}
