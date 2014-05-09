<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/./application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once(APPLICATION_PATH.'/controllers/BaseController.php');
require_once 'VNMLS/includes/common.inc';

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.json'
);

$options = array(
	'includePaths' => array(
		'library' => APPLICATION_PATH. '/../library'),
	'bootstrap' => array(
    	'path' 	=> APPLICATION_PATH . '/Bootstrap.php',
		'class' => 'Bootstrap',
    ),
    'autoloadernamespaces' => array(
    	'vnmls' => 'VNMLS_',
    ),
	'resources' => array(
		'frontController' => array(
			'controllerDirectory' => APPLICATION_PATH . '/controllers'
		),
		'layout' => array(
			'layoutPath' => APPLICATION_PATH. "/layouts/scripts/"
		),
		'view' => array(),
		'session' => array(
			'save_path' => APPLICATION_PATH. "/data/session/"
		)
	) 
);
$options = $application->mergeOptions($application->getOptions(), $options);
$application->setOptions($options)
			->bootstrap()
            ->run();