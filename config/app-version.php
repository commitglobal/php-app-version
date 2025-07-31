<?php

declare(strict_types=1);

return [

    // The path to the file that contains the version of the application.
    // This file should contain a single line with the version string.
    'file' => base_path('.version'),

    // The fallback version to use if the file does not exist.
    'fallback' => 'develop',

    // The Filament hook where the version will be displayed.
    // This can be one of the Filament\View\PanelsRenderHook constants.
    // Defaults to Filament\View\PanelsRenderHook::FOOTER.
    'filament-hook' => null,

];
