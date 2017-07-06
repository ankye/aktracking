<?php

require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/WURFLManagerTest.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/ReloaderTestSuite.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/ConfigurationTestSuite.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/HandlersTestSuite.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/XmlTestSuite.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/Request/UserAgentNormalizerTestSuite.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/DeviceRepositoryBuilderTest.php';
/**
 * Static test suite.
 */
class WURFLTestsSuite extends PHPUnit_Framework_TestSuite {
	
	
	
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		$this->setName ( 'WURFLTestsSuite' );
		
		$this->addTestSuite ( 'WURFL_ConfigurationTestSuite' );
		$this->addTestSuite ( 'WURFL_XmlTestSuite' );
		$this->addTestSuite ( 'WURFL_WURFLManagerTest' );
		$this->addTestSuite ( 'WURFL_Request_UserAgentNormalizerTestSuite' );
		$this->addTestSuite ( 'WURFL_HandlersTestSuite' );
		$this->addTestSuite ( 'WURFL_DeviceRepositoryBuilderTest' );
		$this->addTestSuite ( 'WURFL_ReloaderTestSuite' );
	}
	
	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ();
	}
}

