<?php

namespace Mirage\ThemeManager\Facades;

use Illuminate\Support\Facades\Facade;
use Mirage\ThemeManager\Helpers\Contracts\ThemeInterface;

/**
 * Description of ThemeFacade.
 *
 * @author Bryan Salazar
 */
class ThemeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ThemeInterface::class;
    }
}
