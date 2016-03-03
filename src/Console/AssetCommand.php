<?php namespace Mirage\ThemeManager\Console;

use Illuminate\Console\Command;

use Mirage\ThemeManager\Facades\ThemeFacade;
use Mirage\ThemeManager\Helpers\Contracts\ThemeContract;

/**
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
		$theme = app(ThemeContract::class);
		$themeName = $this->argument('themename');
		$groupName = $this->argument();
	}

	protected function getOptions()
	{
//		parent::getOptions();
		return [];
	}
}

