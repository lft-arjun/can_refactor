<?php
namespace Language\LanguageFiles;

use Language\Services\ApiService;
use Language\Services\ResultCheck;
use Language\Config;

class LanguageFile
{
	protected $application;
	
	protected $language;

	protected $cacheFilePath;
	
	public function __construct($application, $language)
	{
		$this->application = $application;
		$this->language = $language;
		$this->cacheFilePath = Config::get('system.paths.root') . '/cache/' . $this->application. '/';
	}

	/**
	 * Gets the language file for the given language and stores it.
	 *
	 * @param string $application   The name of the application.
	 * @param string $language      The identifier of the language.
	 *
	 * @throws CurlException   If there was an error during the download of the language file.
	 *
	 * @return bool   The success of the operation.
	 */
	public function getLanguageFile()
	{
		$result = false;
	
		$getParams = [
				'system' => 'LanguageFiles',
				'action' => 'getLanguageFile'
			];
		$postParams =['language' => $this->language];

		try {
			$apiService = new ApiService();
			$languageResponse = $apiService->getResult($getParams, $postParams, new ResultCheck);

			// If we got correct data we store it.
			$destination = $this->cacheFilePath . $this->language . '.php';
			// If there is no folder yet, we'll create it.
			var_dump($destination);
			if (!is_dir(dirname($destination))) {
				mkdir(dirname($destination), 0755, true);
			}

			$result = file_put_contents($destination, $languageResponse['data']);

			return (bool)$result;
		}
		catch (\Exception $e) {
			throw new \Exception('Error during getting language file: (' . $this->application . '/' . $this->language . ')');
		}
		
	}

}