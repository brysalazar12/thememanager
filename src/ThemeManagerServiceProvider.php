<?php namespace Mirage\ThemeManager;

use Illuminate\Support\ServiceProvider;
use Mirage\ThemeManager\Helpers\Contracts\ThemeInterface;
use Mirage\ThemeManager\Helpers\Theme;
use Illuminate\View\FileViewFinder;

/**
 * Description of ThemeManager
 *
 * @author Bryan Salazar
 */
class ThemeManagerServiceProvider extends ServiceProvider
{
	protected $defer = false;

	public function boot()
	{
		$basePath = __DIR__ . '/';
		$this->publishes([
			$basePath . 'config/theme.php' => config_path('theme.php')
		]);
		$this->registerViewFinder();
	}

	public function register()
	{
		$this->registerThemeManager();
	}

	protected function registerThemeManager()
	{
		$this->app->singleton(ThemeInterface::class, function($app){
			return new Theme($app);
		});
	}

	public function provides()
	{
		return [ThemeInterface::class];
	}

    public function registerViewFinder()
    {
		$this->mergeConfigFrom(__DIR__ . '/config/theme.php', 'theme');
		$themeManager = $this->app[ThemeInterface::class];
		$basePath = config('theme.basePath');
		$themeManager->setBasePath($basePath);
		$themes = array_keys(config('theme.themes'));

		// set available themes for each group
		foreach($themes as $group => $theme) {
			$themeManager->setThemes($group, $theme);
		}
		$currentGroup = config('theme.current_group');

		if(is_null($themeManager->getCurrentGroup())) {
			$themeManager->setCurrentGroup($currentGroup);
		}

		if(is_null($themeManager->getCurrentTheme($themeManager->getCurrentGroup()))) {
			$currentThemes = config('theme.current_theme');

			// set active theme for each group
			foreach($currentThemes as $group => $theme) {
				$themeManager->set($theme, $group);
			}
			$themeManager->set($currentThemes[$currentGroup],$currentGroup);

		}

		$this->app->bind('view.finder',function($app){
			$themeManager = $app[ThemeInterface::class];
			$paths = $themeManager->getAllAvailablePaths();
			return new FileViewFinder($app['files'], $paths);
		});
    }
}
