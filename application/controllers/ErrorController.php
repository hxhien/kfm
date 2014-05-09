<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        if (!$errors) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;
    }
	
	public function accessdeniedAction(){
		$private_site = $this->getInvokeArg('bootstrap')->getOption('private_site');
		if ($private_site){
			echo "You have no permission to access this page";
			exit;
		}else{
			$this->view->message = "You have no permission to access this page";
			$this->getHelper('viewRenderer')->setScriptAction('error');
		}
    }
	
	public function response404Action(){
		$private_site = $this->getInvokeArg('bootstrap')->getOption('private_site');
		if ($private_site){
			echo "This page not exit";
			exit;
		}else{
			$this->view->message = "This page not exit";
			$this->getHelper('viewRenderer')->setScriptAction('error');
		}
	}

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

}

