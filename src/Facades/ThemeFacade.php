<?php namespace Mirage\ThemeManager\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * Description of ThemeFacade
 *
 * @author Bryan Salazar
 */
class ThemeFacade extends Facade
{
	protected static function getFacadeAccessor() { return 'theme'; }
}
