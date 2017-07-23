<?php
namespace Language\Services;

use Language\LanguageFiles\LanguageFile;
use Language\Applets\LanguageApplet;
use Language\Services\ApiService;
use Language\Config;

/**
* 
*/
class FileService
{
	
	public function __construct()
	{
		# code...
	}

	public function processGenerateLanguageFiles($applications = array())
	{
		echo "\nGenerating language files\n";
		foreach ($applications as $application => $languages) {
			echo "[APPLICATION: " . $application . "]\n";
			foreach ($languages as $language) {
				echo "\t[LANGUAGE: " . $language . "]";
				$langFileObj = new LanguageFile($application, $language);
				if ($langFileObj->getLanguageFile()) {
					echo " OK\n";
				}
				else {
					throw new \Exception('Unable to generate language file!');
				}
			}
		}
	}

	public function processAppletLanguageXmlFiles($appletLanguageId)
	{
		$langAppletObj = new LanguageApplet($appletLanguageId, new ApiService);
		$languages = $langAppletObj->getAppletLanguages();

		if (empty($languages)) {
			throw new \Exception('There is no available languages for the ' . $appletLanguageId . ' applet.');
		}
		else {
			echo ' - Available languages: ' . implode(', ', $languages) . "\n";
		}

		$path = Config::get('system.paths.root') . '/cache/flash';

		foreach ($languages as $language) {
			$xmlContent = $langAppletObj->getAppletLanguageFile($appletLanguageId, $language);
			$xmlFile    = $path . '/lang_' . $language . '.xml';
			if (strlen($xmlContent) == file_put_contents($xmlFile, $xmlContent)) {
				echo " OK saving $xmlFile was successful.\n";
			}
			else {
				throw new \Exception('Unable to save applet: (' . $appletLanguageId . ') language: (' . $language
					. ') xml (' . $xmlFile . ')!');
			}
		}
	}
}