<?php namespace Mirage\ThemeManager\Helpers\Contracts;

/**
 *
 * @author Bryan Salazar
 */
interface ThemeInterface
{
	public function set($theme);

	public function readAllThemes($group);

	public function getCurrentTheme($group);

	public function getAllAvailablePaths();

	public function setBasePath($basePath);

	public function setCurrentGroup($group);

	public function getCurrentGroup();

	public function asset($asset);

	public function setThemes($group, $themes);
}
