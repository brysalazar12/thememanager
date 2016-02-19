<?php namespace Mirage\ThemeManager\Helpers;

use Mirage\ThemeManager\Helpers\Contracts\ThemeContract;
use Illuminate\View\FileViewFinder;

/**
 * Description of Theme
 *
 * @author Bryan Salazar
 */
class Theme implements ThemeContract
{
	protected $themeBasePath;

	protected $basePath;
	protected $currentGroup;
	protected $app;

	/**
	 * Array of theme per group ['group1'=>['theme1','theme2']]
	 * @var array
	 */
	protected $themes;

	/**
	 * Current theme per group ['group1'=>'theme1','group2'=>'theme2']
	 * @var array
	 */
	protected $currentTheme = [];

	public function __construct($app)
	{
		$this->basePath = resource_path('themes');
		$this->app = $app;
	}

	/**
	 * Get current theme for this group
	 * @param string $group
	 * @return string
	 */
	public function getCurrentTheme($group)
	{
		if(!isset($this->currentTheme[$group]))
			return null;

		return $this->currentTheme[$group];
	}

	/**
	 * Read all available theme for this group
	 * @param string $group Group Name
	 * @return array List of themes
	 */
	public function readAllThemes($group)
	{
		return $this->themes[$group];
	}

	/**
	 * Set current theme for this group
	 * @param string $theme Name of theme that belongs to this $group
	 * @param string $group Group name
	 */
	public function set($theme, $group = null)
	{
		if(!is_null($group)) {
			$this->currentGroup = $group;
			$this->currentTheme[$group] = $theme;
		}

		if(is_null($this->currentGroup))
			throw new \Exception ('Current group cannot be null. Use Theme::setCurrentGroup($group) or Theme::set($theme, $group)');


		$this->currentTheme[$this->currentGroup] = $theme;
		return $this;
	}

	public function getAllAvailablePaths()
	{
		if(is_null($this->currentGroup))
			throw new \Exception ('Current group cannot be null. Use Theme::setCurrentGroup($group) or Theme::set($theme, $group)');

		return [
			$this->basePath . '/' . $this->currentGroup . '/' . $this->currentTheme[$this->currentGroup] . '/views'
		];
	}

	/**
	 * Base path of themes
	 * @param string $basePath
	 */
	public function setBasePath($basePath)
	{
		$this->basePath = $basePath;
		return $this;
	}

	/**
	 * Set current group
	 * @param string $group
	 */
	public function setCurrentGroup($group)
	{
		$this->currentGroup = $group;
		return $this;
	}

	/**
	 *
	 * @param type $asset
	 * @return string
	 */
	public function asset($asset)
	{
		return url('/' . $this->currentGroup . '/' . $this->currentTheme . '/' . $asset);
	}

	/**
	 * Set list of themes in this group
	 * @param string $group
	 * @param array $themes
	 */
	public function setThemes($group, $themes)
	{
		$this->themes[$group] = $themes;
		return $this;
	}

	public function getCurrentGroup()
	{
		return $this->currentGroup;
	}

	public function override()
	{
		if($this->app['files']->exists(config_path('theme.php'))) {
			$basePath = config('theme.basePath');
			$this->setBasePath($basePath);
			$themes = array_keys(config('theme.themes'));
			foreach($themes as $group => $theme) {
				$this->setThemes($group, $theme);
			}
			$currentGroup = config('theme.current_group');
			if(is_null($this->getCurrentGroup()))
				$this->setCurrentGroup($currentGroup);
			if(is_null($this->getCurrentTheme($this->getCurrentGroup()))) {
				$currentTheme = config('theme.current_theme');
				$this->set($currentTheme[$this->getCurrentGroup()],
						$this->getCurrentGroup());
			}
		}
		$paths = $this->getAllAvailablePaths();
		$finder =  new FileViewFinder($this->app['files'], $paths);
		$this->app['view']->setFinder($finder);
	}
}
