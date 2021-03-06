<?php
/**
  * com_pvoks
  * Licence: GNU/GPL
  * Author: Fogler Tibor   
  * Author-email: tibor.fogler@gmail.com
  * Author-web: github.com/utopszkij
  * Verzió: V1.00 
 */

defined("_JEXEC") or die("Restricted access");
require_once JPATH_COMPONENT.DS.'models'.DS.'model.php';

class PvoksControllerMembers extends PvoksController {

    function __construct() {
		parent::__construct();
		$this->viewName = 'members';
		$this->modelName = 'members';
		$this->formName = 'members';
		$this->defSort = 'u.username';        
		$this->defOrder = 'asc';        
		$this->defLimit = 20;           
		$this->defTask = 'browse';      
		$this->lngPre = 'PVOKS_';
	}
	
	/**
	* inti jform'fields for save and New function
	*/
	protected function editNewInit(&$jform) {
	  $jform['id'] = 0;	
	  $jform['admin'] = 0;	
	  $jform['state'] = 2;	
	}
	
}
?>
