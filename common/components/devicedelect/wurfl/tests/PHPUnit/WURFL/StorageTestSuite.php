<?php
/**
 * test case
 */
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/Storage/FileTest.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/Storage/ApcTest.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/Storage/MemcacheTest.php';
require_once '../tracking.com/thirdparty/wurfl/tests/PHPUnit/WURFL/Storage/MemoryTest.php';

/**
 * Static test suite.
 */
class WURFL_StorageTestSuite extends PHPUnit_Framework_TestSuite {

	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		$this->setName ( 'StorageTestSuite' );
		$this->addTestSuite ( 'WURFL_Storage_FileTest' );
		//$this->addTestSuite ( 'WURFL_Storage_ApcTest' );
        $this->addTestSuite ( 'WURFL_Storage_MemcacheTest' );
        $this->addTestSuite ( 'WURFL_Storage_MemoryTest' );

	}

	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ( );
	}
}

