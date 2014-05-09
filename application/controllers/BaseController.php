<?php 
/** @see Zend_Controller_Action */ 
require_once 'Zend/Controller/Action.php'; 
 
class BaseController extends Zend_Controller_Action {

	public function preDispatch() {
		// Prevent for alpha
		/*
		$private_site = $this->getInvokeArg('bootstrap')->getOption('private_site');
		if ($private_site){
			$session_pass_view = new Zend_Session_Namespace('pass_view');
			if (!isset($session_pass_view->pass) && $this->getRequest()->getControllerName() != 'auth' &&  $this->getRequest()->getActionName() != 'viewlogin'){
				$this->_helper->getHelper('Redirector')->gotoUrl('/login.html');
			}
		}
		*/
		$arrCommonLbl = array('LBL_MENU_Home', 'LBL_MENU_About Dr. Kwak','LBL_MENU_Staff', 'LBL_MENU_Location and hours', 'LBL_MENU_Contact us',
							  'LBL_MENU_FAQ', 'LBL_MENU_Insurance', 'LBL_MENU_News', 'LBL_MENU_Links', 'LBL_MENU_Forms', 'LBL_MENU_Newsletters',
							  'LBL_MENU_My Patient Page', 'LBL_Testimonials', 'LBL_Languages', 'LBL_Search', 'LBL_Contact information', 'LBL_KFM on Facebook', 'LBL_KFM on Twitter');
		loadDictionary($arrCommonLbl);	
    }
	
    public function postDispatch() {
		parent::postDispatch();
		$this->view->controllerObject = $this;
		$this->view->module = $this->getRequest()->getModuleName();
		$this->view->controller = $this->getRequest()->getControllerName();
		$this->view->action = $this->getRequest()->getActionName();
	}
}
