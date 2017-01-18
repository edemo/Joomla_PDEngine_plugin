<?php
define('JPATH_COMPONENT', 'admin');
require_once "UnitTest/testJoomlaFramework.php";
require_once "admin/controllers/controller.php";
require_once "admin/helpers/pvoks.php";
require_once "admin/controllers/options.php";

class pvoksTestOptions extends PHPUnit_Framework_TestCase {
	protected $controller;
	function __construct() {
		global $testData,$componentName,$viewName;
		$componentName = 'pvoks';
		$viewName = 'options';
		parent::__construct();
		$this->controller = new PvoksControllerOptions();
	}
    protected function setUp() {
		global $testData,$componentName;
		$testData->clear();
		$componentName = 'pvoks';
	}
	public function test_options_browse0()  {
		global $testData;
		// nincs megjelenitendő rekord
		$testData->clear();
		$this->controller->browse();
		$this->expectOutputRegex('/PVOKS_NO_DATA/');
	}
	public function test_options_browse1()  {
		global $testData;
		// van megjelenitendő rekord
		$testData->clear();
		$testData->addDbResult(JSON_decode('[{"id":1,"title":"probaTitle1"},{"id":2,"title":"probaTitle2"}]'));
		$this->controller->browse();
		$this->expectOutputRegex('/probaTitle2/');
    }
	public function test_options_add()  {
		global $testData;
		$testData->clear();
		$this->controller->add();
		$this->expectOutputRegex('/PVOKS_BTN_SAVE/');
    }
	public function test_options_edit0()  {
		global $testData;
		// nincs kijelölt a rekord
		$testData->clear();
		$this->controller->edit();
		$this->expectOutputRegex('/PVOKS_SELECT_PLEASE/');
	}
	public function test_options_edit1()  {
		global $testData;
		// meg van a rekord
		$testData->clear();
		$testData->addDbResult(JSON_decode('{"id":1,"title":"probaTitle1"}'));
		$testData->setInput('id',1);
		$this->controller->edit();
		$this->expectOutputRegex('/PVOKS_BTN_SAVE/');
    }
    public function test_options_delete0()  {
		global $testData;
		// nincs kijelölt rekord
		$testData->clear();
		$this->controller->delete();
		$this->expectOutputRegex('/PVOKS_SELECT_PLEASE/');
    }		
    public function test_options_delete1()  {
		global $testData;
		// meg van a rekord
		$testData->clear();
		$testData->addDbResult(JSON_decode('{"id":1,"title":"probaTitle1"}'));
		$testData->setInput('id',1);
		$this->controller->delete();
		$this->expectOutputRegex('/DELETED/');
	}
    public function test_options_save0()  {
		global $testData;
		// a formon nincsenek kitöltve az igényelt mezők
		$testData->clear();
		$this->controller->save();
		$this->expectOutputRegex('/REQUED/');
	}	
    public function test_options_save1()  {
		
		echo '-------------test_option_save1 ----------------';
		
		global $testData;
		// új felvitel , de az alias már létezik az adatbázisban
		$testData->clear();
		$testData->setInput('jform',array("id" => 0, "title" => "testTitle1", "question_id" => 1));
		$testData->addDbResult(JSON_decode('[{"id":12,"name":"acredited1"}]')); // record duplicate check
		$this->controller->save();
		$this->expectOutputRegex('/PVOKS_ALIAS_USED/');
	}	
    public function test_options_save3()  {
		global $testData;
		// új felvitel jó adatokkal
		$testData->clear();
		$testData->setInput('jform',array("id" => 0, "title" => "testTitle1", "question_id" => 1));
		$testData->addDbResult(array()); // alias duplicate check
		$this->controller->save();
		$this->expectOutputRegex('/SAVED/');
	}
    public function test_options_save4()  {
		global $testData;
		// modositás jó adatokkal
		$testData->clear();
		$testData->setInput('jform',array("id" => 1, "title" => "testTitle1", "question_id" => 1));
		$testData->addDbResult(array()); // alias duplicate check
		$this->controller->save();
		$this->expectOutputRegex('/SAVED/');
    }
}	
?>