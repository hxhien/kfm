<?php
require_once 'Zend/Controller/Action.php'; 

class NodeController extends BaseController
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->view->keyword = 'Kwak Family Medicine, James Kwak MD, Doctor James Kwak, Dr Kwak';
        $this->view->description = 'Kwak Family Medicine, PC, the practice of James J. Kwak, MD. KFM is a solo primary-care office that cares for all ages from infants to the elderly';
    }

    public function indexAction()
    {
    	$db = VNMLS_Db_Table::getDB();
    	$type = 'page';
    	if (isset($_GET['type']) && $_GET['type'] != '') $type = $_GET['type'];
    	$results = $db->fetchAll("SELECT * FROM node where type = ".$db->quote($type)." ORDER BY node.id DESC");
    	$this->view->nodes = $results;
    	$this->view->node_type = $type;
    }
    
    public function detailAction(){
    	$node_id = '';
    	if (isset($_GET['id']) && $_GET['id'] != '') $node_id = $_GET['id']; 
//     	$arrLanguage = array('en', 'kr', 'vi');
    	$arrLanguage = array('en', 'kr');
    	if (isset($node_id) && $node_id != ''){
    		$node = VNMLS_Db_Table::fetch("Node", $node_id);
	    	$this->view->status = $node->status;
	    	$this->view->node_type = $node->type;
	    	$this->view->node_id = $node_id;
	    	$this->view->node_name = $node->title;
	    	if ( in_array($node->type, array('page', 'block', 'news', 'faq'))){
	    		$contents = $node->getNodeContent();
	    		foreach($contents as $content){
	    			$title_lbl = "title_".$content['language'];
	    			$body_lbl = "body_".$content['language'];
	    			$this->view->$title_lbl = $content['title'];
	    			$this->view->$body_lbl = $content['body'];
	    		}
	    	}else if ($node->type == 'testimonial'){
	    		$contents = $node->getNodeContent();
	    		foreach($contents as $content){
	    			$body_lbl = "body_".$content['language'];
	    			$this->view->$body_lbl = $content['body'];
	    		}
	    	}else if ($node->type == 'label'){
	    		$contents = $node->getNodeContent();
	    		foreach($contents as $content){
	    			$title_lbl = "title_".$content['language'];
	    			$this->view->$title_lbl = $content['title'];
	    		}
	    	}else if ($node->type == 'link'){
	    		$contents = $node->getNodeContent();
	    		foreach($contents as $content){
	    			$title_lbl = "title_".$content['language'];
	    			$url_lbl = "url_".$content['language'];
	    			$this->view->$title_lbl = $content['title'];
	    			$this->view->$url_lbl = $content['url'];
	    		}
	    	}
    	}else{
    		$type = $_GET['type'];
    		if (!isset($type) || $type == '') $type = 'page';
	    	$this->view->status = 'draft';
	    	$this->view->node_type = $type;
    	}
    }
    
    public function detailconfirmAction(){
    	$node_id = $_POST['node_id'];
    	$node_name = $_POST['node_name'];
    	$node_type = $_POST['node_type'];
    	$status = $_POST['status'];
    	if (get_magic_quotes_gpc()) {
    		$node_name = stripslashes($node_name);
    	}
    	$db = VNMLS_Db_Table::getDB();
    	$editMode = true;
    	if ($node_id == ''){
			$nodes = new VNMLS_Model_Table_Node();
			$node = $nodes->createRow();
			$editMode = false;
		}else{
			$node = VNMLS_Db_Table::fetch("Node", $node_id);
			$db->delete("node_{$node_type}_content","node_id = $node_id");
		}
		$node->type = $node_type;
		$node->title = $node_name;
		$languages = array('en', 'kr');
		$arrLanguage = array();
		$arrContent = array();
		$node->status = $status;
		if ( in_array($node->type, array('page', 'block', 'news', 'faq'))){
			foreach($languages as $language){
				$title_text = $_POST['title_'.$language];
				$body_text = $_POST['body_'.$language];
				if ($title_text != '' || $body_text != ''){
					if (get_magic_quotes_gpc()) {
			    		$title_text = stripslashes($title_text);
			    		$body_text = stripslashes($body_text);
			    	}
					$arrLanguage[] = $language;
					$arrContent[] = array('body' => $body_text, 'title' => $title_text);
				}
			}
		}else if ($node->type == 'testimonial'){
			foreach($languages as $language){
				$body_text = $_POST['body_'.$language];
				if ($body_text != ''){
					if (get_magic_quotes_gpc()) {
			    		$body_text = stripslashes($body_text);
			    	}
					$arrLanguage[] = $language;
					$arrContent[] = array('body' => $body_text);
				}
			}
		}else if ($node->type == 'label'){
			foreach($languages as $language){
				$title_text = $_POST['title_'.$language];
				if (get_magic_quotes_gpc()) {
		    		$title_text = stripslashes($title_text);
		    	}
				$arrLanguage[] = $language;
				$arrContent[] = array('title' => $title_text);
			}
		}else if ($node->type == 'link'){
			foreach($languages as $language){
				$title_text = $_POST['title_'.$language];
				$url_text = $_POST['url_'.$language];
				if ($title_text != '' || $url_text != ''){
					if (get_magic_quotes_gpc()) {
			    		$title_text = stripslashes($title_text);
			    		$url_text = stripslashes($url_text);
			    	}
					$arrLanguage[] = $language;
					$arrContent[] = array('url' => $url_text, 'title' => $title_text);
				}
			}
		}
		$node->languages = implode(",", $arrLanguage);
    	$node->save();
    	if (sizeof($arrContent) > 0){
			for($idx = 0; $idx < sizeof($arrContent); $idx++){
				$data = $arrContent[$idx];
				$data['node_id'] = $node->id;
				$data['language'] = $arrLanguage[$idx];
				$db->insert("node_". $node->type ."_content", $data);
			}
    	}
    	$this->view->node_type = $node_type;
    	$this->view->editMode = $editMode;
    }
    
    public function historyAction(){
    	
    }
}

