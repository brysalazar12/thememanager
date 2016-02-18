<?php namespace Mirage\ThemeManager;

use Illuminate\Support\ServiceProvider;
use Mirage\ThemeManager\Helpers\Contracts\ThemeContract;
use Mirage\ThemeManager\Helpers\Theme;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;
use Mirage\ThemeManager\Events\ThemeViewEvent;

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
        $this->app->bind(\Illuminate\Contracts\View\Factory::class, function ($app) {
            $resolver = $app['view.engine.resolver'];

			$app->bind('view.finder',function($app){

				$themeManager = $app['theme'];

				if($app['files']->exists(config_path('theme.php'))) {
					$basePath = config('theme.basePath');
					$themeManager->setBasePath($basePath);
					$themes = array_keys(config('theme.themes'));
					foreach($themes as $group => $theme) {
						$themeManager->setThemes($group, $theme);
					}

					$currentGroup = config('theme.current_group');
					if(is_null($themeManager->getCurrentGroup()))
						$themeManager->setCurrentGroup($currentGroup);


					if(is_null($themeManager->getCurrentTheme($themeManager->getCurrentGroup()))) {
						$currentTheme = config('theme.current_theme');
						$themeManager->set($currentTheme[$themeManager->getCurrentGroup()],
								$themeManager->getCurrentGroup());
					}
				}
				$paths = $themeManager->getAllAvailablePaths();
				return new FileViewFinder($app['files'], $paths);
			});


            $finder = $app['view.finder'];

            $env = new Factory($resolver, $finder, $app['events']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);

            $env->share('app', $app);

			event('theme.view', new ThemeViewEvent());
            return $env;
        });
    }
}
