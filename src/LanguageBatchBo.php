<?php

namespace Language;

use Language\Services\FileService;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
	/**
	 * Contains the applications which ones require translations.
	 *
	 * @var array
	 */
	protected $applications = array();


	public function __construct()
	{
		// The applications where we need to translate.
		$this->applications = Config::get('system.translated_applications');
	}
	/**
	 * Starts the language file generation.
	 *
	 * @return void
	 */
	public function generateLanguageFiles()
	{
		$fileService = new FileService();
		$fileService->processGenerateLanguageFiles($this->applications);
	}

	/**
	 * Gets the language files for the applet and puts them into the cache.
	 *
	 * @throws Exception   If there was an error.
	 *
	 * @return void
	 */
	public function generateAppletLanguageXmlFiles()
	{
		// List of the applets [directory => applet_id].
		$applets = array(
			'memberapplet' => 'JSM2_MemberApplet',
		);

		echo "\nGetting applet language XMLs..\n";

		foreach ($applets as $appletDirectory => $appletLanguageId) {
			echo " Getting > $appletLanguageId ($appletDirectory) language xmls..\n";
			$fileService = new FileService();
			$fileService->processAppletLanguageXmlFiles($appletLanguageId);

			echo " < $appletLanguageId ($appletDirectory) language xml cached.\n";
		}

		echo "\nApplet language XMLs generated.\n";
	}
	
}
