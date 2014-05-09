<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public $defaultLanguage = 'en';
	public $urlLanguage;
	public $currentLanguage;
	public $languageURLs = array();

	protected function _initDoctype()
	{
		$this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
	}
	
	protected function _initAutoload()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();	
		return $autoloader;
	}
	
	public function run () {
		//$this->setupRouter();
		$this->setupLanguage();
		$this->handleAuth();
		$db = $this->getResource('db');
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		$character_set = "SET NAMES 'utf8'";
		$db->query($character_set);
		parent::run();
	}
	
	public function setupLanguage(){
		global $en_url;
		global $vi_url;
		global $kr_url;
		global $current_language;
		$dictionaries = array();
		$site_name = $this->getOption('site_name');
		$hostName = $_SERVER['HTTP_HOST'];
		$this->urlLanguage = $this->defaultLanguage;
		if (strpos($hostName, "vi.") !== false) $this->urlLanguage = 'vi';
		if (strpos($hostName, "kr.") !== false) $this->urlLanguage = 'kr';
		$referer_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;
		//$referer_url = $referer_url ? str_replace("/kr.", "/", $referer_url) : false;
		//$referer_url = $referer_url ? str_replace("/vi.", "/", $referer_url) : false;
		if ( isset($_SERVER['HTTP_HOST']) )
			$request_url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		else
			$request_url = "";
		if (strpos($request_url, "www.") !== false){
			$request_url = str_replace("www.", "", $request_url);
			header('Location: ' . $request_url);
			exit;
		}
		$language = $this->defaultLanguage;
		if ( isset($_COOKIE["language"]) && $_COOKIE["language"] )
			$language = $_COOKIE["language"];
		
		if ( $this->urlLanguage ) $language = $this->urlLanguage;
		
		// we know language for current request, so set
		$this->currentLanguage = $language;
		//$locale = new Zend_Locale($language);
		//$translate = new Zend_Translate('csv', _DOCROOT . 'languages/'.$language.'.csv', $language);
		$real_url = str_replace("/kr.", "/", $request_url);
		$real_url = str_replace("/vi.", "/", $real_url);
		$this->languageURLs = array('en' => $real_url, 'vi' => str_replace("http://", "http://vi.", $real_url), 
									'kr' => str_replace("http://", "http://kr.", $real_url));
		
		$vi_url = $this->languageURLs['vi'];
		$en_url = $this->languageURLs['en'];
		$kr_url = $this->languageURLs['kr'];
		
		if ( $referer_url && $referer_url != $request_url && (!isset($_COOKIE["language"]) || $language != $_COOKIE["language"])) {
			setcookie("language", $language, time() + 365*24*3600, "/", ".$site_name");
			$_COOKIE["language"] = $language;
		}
			
		if ( isset($_COOKIE["language"]) && $_COOKIE["language"] != $this->urlLanguage ) {
			header('Location: ' . $this->languageURLs[$_COOKIE["language"]]);
			exit;
		}
		$current_language = $language;
		global $dictionaries;
		$dictionaries = array();
	}
	
	public function handleAuth(){
		$this->auth = Zend_Auth::getInstance();
		$role = 'guest';
		// Create auth object			
		if ( $this->auth->hasIdentity() ) {
			$ident = $this->auth->getIdentity();
			$session = new Zend_Session_Namespace('auth');
			$user = VNMLS_Model_Table_Users::getCurrentUser();
			if ($user->status != "disabled" && $user->status != "expired"){
				$role = $user->role;
				$authNamespace = new Zend_Session_Namespace('Zend_Auth');
				$authNamespace->setExpirationSeconds(60*60*60);
			}else{
				$this->auth->clearIdentity();
			}
		}
		// Create acl object
		$this->acl = new VNMLS_Acl($this->auth);
		$front = $this->getResource('FrontController');
		$front->registerPlugin(new VNMLS_Controller_Plugin_Acl($this->acl, $role));
	}
}

