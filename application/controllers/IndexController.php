<?php
require_once 'Zend/Controller/Action.php'; 

class IndexController extends BaseController
{

    public function init()
    {
        /* Initialize action controller here */
        loadDictionary("LBL_Where Your Family’s Health Is Protected");
        $this->view->keyword = 'Kwak Family Medicine, James Kwak MD, Doctor James Kwak, Dr Kwak';
        $this->view->description = 'Kwak Family Medicine, PC, the practice of James J. Kwak, MD. KFM is a solo primary-care office that cares for all ages from infants to the elderly';
    }

    public function patientfusionAction()
    {
        $data = file_get_contents("https://www.patientfusion.com/doctor/james-kwak-md-faafp-90926");
        echo $data;
        exit;
    }

    public function facebookAction()
    {
        $lastest_post_id_saved = VNMLS_Model_Table_Node::getLastestFbPostId();
        if (!$lastest_post_id_saved){
            $lastest_post_id_saved = 0;
        }
        $page_oauth = file_get_contents('https://graph.facebook.com/oauth/access_token?client_id=112687442090932&client_secret=288d9a35d42d4c82b61f13a762026d96&grant_type=client_credentials');
        $token = substr($page_oauth, 13);
        //$token = '112687442090932|5J2FYZjxL3tGvNxpOv0Cj_AeLMU';
        $page_posts = file_get_contents('https://graph.facebook.com/158413460880351/posts?fields=message&access_token='.$token);
        $pageposts = json_decode($page_posts);
        $db = VNMLS_Db_Table::getDB();
        foreach($pageposts->data as $post){
            if (isset($post->message)){
                $post_id = explode('_', $post->id);
                $post_id = $post_id[1];
                if ($post_id <= $lastest_post_id_saved){
                    break;
                }
                $nodes = new VNMLS_Model_Table_Node();
			    $node = $nodes->createRow();
                $node->type = 'news';
		        $node->title = "Facebook post {$post_id}";
                $node->status = 'active';
                $node->languages = 'en';
    	        $node->save();
                $data = array();
                $data['node_id'] = $node->id;
				$data['language'] = 'en';
                $data['body'] = $post->message;
                $data['post_id'] = $post_id;
                $created_time = $post->created_time;
                $created_time = str_replace("T", " ", $created_time);
                $created_time = str_replace("+0000", "", $created_time);
                $data['created_date'] = $created_time;
				$db->insert("node_news_content", $data);
            }
        }
        exit;
    }
    
    public function indexAction()
    {
    	global $current_language;
    	$node = VNMLS_Db_Table::fetch("Node", 1);
    	$content = $node->getNodeContentByLanguage($current_language);
    	$this->view->title = $content['title'];
    	$this->view->body = $content['body'];
    	loadDictionary(array("LBL_About Our Practice", "LBL_Core_Values_KFM"));
    }

    public function aboutAction(){
    	global $current_language;
    	$node = VNMLS_Db_Table::fetch("Node", 2);
    	$content = $node->getNodeContentByLanguage($current_language);
    	$this->view->title = $content['title'];
    	$this->view->body = $content['body'];
    	$this->view->keyword = 'About James Kwak MD, About Doctor James Kwak, About Dr Kwak';
        $this->view->description = 'James Jihoon Kwak, M.D (Dr Kwak) pursued his medical degree at UMDNJ-Robert Wood Johnson Medical School.  He was the recipient of the departmental award in Family Medicine at his graduation. Dr. Kwak completed his Family Medicine training at Crozer-Keystone Family Medicine Residency and became board-certified in 2004.  He then spent seven years at a large group practice in Haddon Heights, New Jersey and enjoyed the popularity and love from his patients and staff until he decided to start Kwak Family Medicine, PC';
    }
	
	public function faqAction(){
    	$this->view->title = _t('LBL_MENU_Faq');
    	$this->view->body = VNMLS_Model_Table_Node::getListFaqHTML();
    }
    
    public function insuranceAction(){
    	global $current_language;
    	$node = VNMLS_Db_Table::fetch("Node", 4);
    	$content = $node->getNodeContentByLanguage($current_language);
    	$this->view->title = $content['title'];
    	$this->view->body = $content['body'];
    }
    
    public function linksAction(){
    	global $current_language;
    	$this->view->title = _t('LBL_MENU_Links');
    	$this->view->body = VNMLS_Model_Table_Node::getListLinkHTML();
    }
    
    public function formsAction(){
    	global $current_language;
    	$node = VNMLS_Db_Table::fetch("Node", 7);
    	$content = $node->getNodeContentByLanguage($current_language);
    	$this->view->title = $content['title'];
    	$this->view->body = $content['body'];
    }
    
    public function locationAction(){
    	global $current_language;
    	$this->view->title = _t('LBL_MENU_Location and hours');
    }
    
    public function staffAction(){
    	global $current_language;
    	$this->view->title = _t('LBL_MENU_Staff');
    	//$this->view->body = VNMLS_Model_Table_Node::getListLinkHTML();
    }
    
    public function newslettersAction(){
    	global $current_language;
    	$this->view->title = _t('LBL_MENU_Newsletters');
    	//$this->view->body = VNMLS_Model_Table_Node::getListLinkHTML();
    }

    public function newsAction(){
    	$this->view->title = _t('LBL_MENU_News');
    	$startNo = 0;
    	if (isset($_GET['s']) && is_numeric($_GET['s'])) $startNo = $_GET['s'];
    	$contents = VNMLS_Model_Table_Node::getListNews($startNo);
    	$this->view->body = $contents['html'];
        $this->view->total= $contents['total'];
    	/*
        $viewNext = false;
    	$viewBack = false;
    	if ($startNo > 0) $viewBack = true;
    	if ($startNo + VNMLS_Model_Table_Node::$NUMBER_NEWS_PER_PAGE > $contents['total']) $viewNext = true;
        */
    }
    
    public function contactAction(){
    	global $current_language;
    	$node = VNMLS_Db_Table::fetch("Node", 26);
    	$content = $node->getNodeContentByLanguage($current_language);
    	$this->view->title = $content['title'];
    	$this->view->body = $content['body'];
    }
    
    public function loginAction() {
    	$this->auth = Zend_Auth::getInstance();
		if ( $this->auth->hasIdentity() ) {
			$defaultNamespace = new Zend_Session_Namespace('Default');
			if (isset($defaultNamespace->urlBack) && $defaultNamespace->urlBack != ""){
				$urlBack = $defaultNamespace->urlBack;
				unset($defaultNamespace->urlBack);
				$this->_helper->getHelper('Redirector')->setUseAbsoluteUri(true);
				$this->_helper->getHelper('Redirector')->gotoUrl($urlBack);
			}else{
				$this->_helper->getHelper('Redirector')->gotoUrl('/index/');
			}
    		return;
		}
		$front = Zend_Controller_Front::getInstance();
		$acl = $front->getPlugin('VNMLS_Controller_Plugin_Acl');
		$this->view->message = $acl->getLoginMessage($this->_request);
		$this->view->title = "Login";
	}
	
	public function logoutAction() {
		Zend_Controller_Front::getInstance()->getPlugin('VNMLS_Controller_Plugin_Acl')->logout();
		$this->getHelper('viewRenderer')->setScriptAction('login');
		$this->view->message = 'You have logged out.';
	}
	
	public function pageAction() {
		$url = $_SERVER["REQUEST_URI"];
		$bits = explode("/", $url);
		$idx = 0;
		for(; $idx <sizeof($bits); $idx++){
			if ($bits[$idx] == 'page') {
				$idx++;
				break;
			}
		}
		if (isset($bits[$idx]) && is_numeric($bits[$idx])){
			global $current_language;
			$title = "Wrong url";
			$body = "This page not exist";
			$node = VNMLS_Db_Table::fetch("Node", $bits[$idx]);
			if ($node){
    			$content = $node->getNodeContentByLanguage($current_language);
    			if ($content){
    				$title = $content['title'];
    				$body = $content['body'];
    			}
			}
    		$this->view->title = $title;
    		$this->view->body = $body;
		}else{
			echo "Wrong url";exit;
		}
	}
	
	function testAction(){
		if (get_magic_quotes_gpc()) echo "ON";
		else echo "OFF";
		exit;
	}
}

