<?php 

namespace Mirage\ThemeManager\Console;

use Illuminate\Console\Command;
use Mirage\ThemeManager\Helpers\Contracts\ThemeInterface;

/**
 * 
 * Publish assets to public
 *
 * @author Bryan Salazar
 */
class AssetCommand extends Command
{
	protected $signature = 'assets:publish {themename} {--group_name= : Group name where the theme belong.}';

	protected $description = 'Publish the assets to public directory.';

	public function handle()
	{

		$themeName = $this->argument('themename');
		$groupName = $this->argument('groupname');
		$theme = app(ThemeInterface::class);
		$theme->set($themeName,$groupName);
	}

	protected function getOptions()
	{
		return [];
	}
}
