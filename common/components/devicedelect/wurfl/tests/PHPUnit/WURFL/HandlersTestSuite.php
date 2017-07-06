<?php
/**
 * test case
 */
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/Handlers/BotCrawlerTranscoderHandlerTest.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/Handlers/MotorolaHandlerTest.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/Handlers/MSIEHandlerTest.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/Handlers/UtilsTest.php';

/**
 * Static test suite.
 */
class WURFL_HandlersTestSuite extends PHPUnit_Framework_TestSuite {
	
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		$this->setName ( 'HandlersTestSuite' );		
		$this->addTestSuite ( 'WURFL_Hanlders_BotCrawlerTranscoderHandlerTest' );
        $this->addTestSuite ( 'WURFL_Hanlders_MotorolaHandlerTest' );    
		$this->addTestSuite ( 'WURFL_Handlers_MSIEHandlerTest' );
		$this->addTestSuite ( 'WURFL_Handlers_UtilsTest' );
	
	}
	
	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ( );
	}
}

