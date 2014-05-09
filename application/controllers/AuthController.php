<?php
require_once 'Zend/Controller/Action.php'; 

class AuthController extends BaseController
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->view->keyword = 'Kwak Family Medicine, James Kwak MD, Doctor James Kwak, Dr Kwak';
        $this->view->description = 'Kwak Family Medicine, PC, the practice of James J. Kwak, MD. KFM is a solo primary-care office that cares for all ages from infants to the elderly';
    }

    public function loginAction()
    {
    	$db = VNMLS_Db_Table::getDB();
    	$type = 'page';
    	if (isset($_GET['type']) && $_GET['type'] != '') $type = $_GET['type'];
    	$results = $db->fetchAll("SELECT * FROM node where type = ".$db->quote($type));
    	$this->view->nodes = $results;
    	$this->view->node_type = $type;
    }
    
    public function viewloginAction(){
    	$url = '/login.html';
    	if (isset($_POST['username'])){
    		if ($_POST['username'] == 'kwak' && $_POST['password'] == 'hien12345'){
    			$session_pass_view = new Zend_Session_Namespace('pass_view');
    			$session_pass_view->pass = 'true';
    			$url = '/index/';
    		}
    	}
    	$this->_helper->getHelper('Redirector')->gotoUrl($url);
    	exit;
    }
}

