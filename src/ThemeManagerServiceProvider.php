<?php namespace Mirage\ThemeManager;

use Illuminate\Support\ServiceProvider;
use Mirage\ThemeManager\Helpers\Contracts\ThemeContract;
use Mirage\ThemeManager\Helpers\Theme;
use Illuminate\View\FileViewFinder;

/**
 * Description of ThemeManager
 *
 * @author Bryan Salazar
 */
class ThemeManagerServiceProvider extends ServiceProvider
{
	protected $defer = true;

	public function boot()
	{
		$basePath = __DIR__ . '/';
		$this->publishes([
			$basePath . 'config/theme.php' => config_path('theme.php')
		]);
	}

	public function register()
	{
		$this->registerThemeManager();
		$this->registerViewFinder();
	}

	protected function registerThemeManager()
	{
		$this->app->singleton('theme',function($app){
			return $app->make(ThemeContract::class);
		});

		$this->app->singleton(ThemeContract::class, function(){
			return new Theme();
		});
	}

	public function provides()
	{
		return ['theme'];
	}

    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {
			$themeManager = $app['theme'];

			if($app['files']->exists(config_path('theme.php'))) {
				$basePath = config('theme.basePath');
				$themeManager->setBasePath($basePath);
				$themes = array_keys(config('theme.themes'));
				foreach($themes as $group => $theme) {
					$themeManager->setThemes($group, $theme);
				}

				$currentThemes = config('theme.current_theme');
				foreach($currentThemes as $group => $currentTheme) {
					$themeManager->set($currentTheme,$group);
				}

				$currentGroup = config('theme.current_group');
				$themeManager->setCurrentGroup($currentGroup);
			}

			$paths = $themeManager->getAllAvailablePaths();

            return new FileViewFinder($app['files'], $paths);
        });
    }
}
