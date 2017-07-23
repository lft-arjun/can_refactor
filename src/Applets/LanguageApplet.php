<?php
namespace Language\Applets;

use Language\Api\ApiCall;
use Language\Services\ApiService;
use Language\Services\ResultCheck;

/**
* 
*/
class LanguageApplet
{
	protected $apiService;
	
	public function __construct($applet, ApiService $apiService)
	{
		$this->applet = $applet;
		$this->apiService = $apiService;
	}

	/**
	 * Gets the available languages for the given applet.
	 *
	 * @param string $applet   The applet identifier.
	 *
	 * @return array   The list of the available applet languages.
	 */
	public function getAppletLanguages()
	{
		$getParams = [
				'system' => 'LanguageFiles',
				'action' => 'getAppletLanguages'
			];
		$postParams =  ['applet' => $this->applet];
		

		try {
			$result = $this->apiService->getResult($getParams, $postParams, new ResultCheck);	
			return $result['data'];
		}
		catch (\Exception $e) {
			throw new \Exception('Getting languages for applet (' . $this->applet . ') was unsuccessful ' . $e->getMessage());
		}

		
	}

	/**
	 * Gets a language xml for an applet.
	 *
	 * @param string $applet      The identifier of the applet.
	 * @param string $language    The language identifier.
	 *
	 * @return string|false   The content of the language file or false if weren't able to get it.
	 */
	public function getAppletLanguageFile($applet, $language)
	{
		$getParams = [
				'system' => 'LanguageFiles',
				'action' => 'getAppletLanguageFile'
			];
		$postParams = [
				'applet' => $applet,
				'language' => $language
			];


		try {
			$result = $this->apiService->getResult($getParams, $postParams, new ResultCheck);	
			return $result['data'];
		}
		catch (\Exception $e) {
			throw new \Exception('Getting language xml for applet: (' . $applet . ') on language: (' . $language . ') was unsuccessful: '
				. $e->getMessage());
		}
	}

}