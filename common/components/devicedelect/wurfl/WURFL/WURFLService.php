<?php
/**
 * Copyright (c) 2015 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the COPYING.txt file distributed with this package.
 *
 *
 * @category   WURFL
 * @package	WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license	GNU Affero General Public License
 * @version	$id$
 */

/**
 * WURFL Service
 * @package	WURFL
 */
class WURFL_WURFLService {
	
	/**
	 * @var WURFL_DeviceRepository
	 */
	private $_deviceRepository;
	/**
	 * @var WURFL_UserAgentHandlerChain
	 */
	private $_userAgentHandlerChain;
	/**
	 * @var WURFL_Storage
	 */
	private $_cacheProvider;
	
	public function __construct(WURFL_DeviceRepository $deviceRepository, WURFL_UserAgentHandlerChain $userAgentHandlerChain, WURFL_Storage $cacheProvider) {
		$this->_deviceRepository = $deviceRepository;
		$this->_userAgentHandlerChain = $userAgentHandlerChain;
		$this->_cacheProvider = $cacheProvider;
	}
	
	/**
	 * Returns the version info about the loaded WURFL
	 * @return WURFL_Xml_Info WURFL Version info
	 * @see WURFL_DeviceRepository::getWURFLInfo()
	 */
	public function getWURFLInfo() {
		return $this->_deviceRepository->getWURFLInfo();
	}
	
	/**
	 * Returns the Device for the given WURFL_Request_GenericRequest
	 *
	 * @param WURFL_Request_GenericRequest $request
	 * @return WURFL_CustomDevice
	 */
	public function getDeviceForRequest(WURFL_Request_GenericRequest $request) {
		$deviceId = $this->deviceIdForRequest($request);
		return $this->getWrappedDevice($deviceId, $request);
	
	}
	
	/**
	 * Retun a WURFL_Xml_ModelDevice for the given device id. If $request is included, it will
	 * be used to resolve virtual capabilties.
	 *
	 * @param string $deviceID
	 * @param WURFL_Request_GenericRequest $request
	 * @return WURFL_Xml_ModelDevice
	 */
	public function getDevice($deviceID, $request=null) {
		if ($request !== null) {

			if (!($request instanceof WURFL_Request_GenericRequest)) {
				throw new InvalidArgumentException("Error: Request parameter must be null or instance of WURFL_Request_GenericRequest");
			}

			// Normalization must be performed if request is passed so virtual capabilities can be
			// resolved correctly.  This is normally handled in self::deviceIdForRequest()
			$generic_normalizer = WURFL_UserAgentHandlerChainFactory::createGenericNormalizers();
			$request->userAgentNormalized = $generic_normalizer->normalize($request->userAgent);
		}
		return $this->getWrappedDevice($deviceID, $request);
	}
	
	/**
	 * Returns all devices ID present in WURFL
	 *
	 * @return array of strings
	 */
	public function getAllDevicesID() {
		return $this->_deviceRepository->getAllDevicesID();
	}
	
	/**
	 * Returns an array of all the fall back devices starting from
	 * the given device
	 *
	 * @param string $deviceID
	 * @return array
	 */
	public function getDeviceHierarchy($deviceID) {
		return $this->_deviceRepository->getDeviceHierarchy($deviceID);
	}
	
	public function getListOfGroups() {
		return $this->_deviceRepository->getListOfGroups();
	}
	
	
	public function getCapabilitiesNameForGroup($groupId) {
		return $this->_deviceRepository->getCapabilitiesNameForGroup($groupId);
	}
	
	// ******************** private functions *****************************
	

	/**
	 * Returns the device id for the device that matches the $request
	 * @param WURFL_Request_GenericRequest $request WURFL Request object
	 * @return string WURFL device id
	 */
	private function deviceIdForRequest($request) {
		$deviceId = $this->_cacheProvider->load($request->id);
		if (empty($deviceId)) {
            $generic_normalizer = WURFL_UserAgentHandlerChainFactory::createGenericNormalizers();
            $request->userAgentNormalized = $generic_normalizer->normalize($request->userAgent);

            if (WURFL_Configuration_ConfigHolder::getWURFLConfig()->isHighPerformance() && WURFL_Handlers_Utils::isDesktopBrowserHeavyDutyAnalysis($request->userAgentNormalized)) {
                // This device has been identified as a web browser programatically, so no call to WURFL is necessary
                return WURFL_Constants::GENERIC_WEB_BROWSER;
            }

			$deviceId = $this->_userAgentHandlerChain->match($request);
			// save it in cache
			$this->_cacheProvider->save($request->id, $deviceId);
		} else {
			$request->matchInfo->from_cache = true;
			$request->matchInfo->lookup_time = 0.0;
		}
		return $deviceId;
	}
	
	/**
	 * Wraps the model device with WURFL_Xml_ModelDevice.  This function takes the
	 * Device ID and returns the WURFL_CustomDevice with all capabilities.
	 *
	 * @param string $deviceID
	 * @param WURFL_Request_GenericRequest|null $request
	 * @return WURFL_CustomDevice
	 */
	private function getWrappedDevice($deviceID, $request = null) {
		$modelDevices = $this->_cacheProvider->load('DEVS_'.$deviceID);

		if (empty($modelDevices)) {
			$modelDevices = $this->_deviceRepository->getDeviceHierarchy($deviceID);
		}

		$this->_cacheProvider->save('DEVS_'.$deviceID, $modelDevices);

		if ($request === null) {
			// If a request was not provided, we generate one from the WURFL entry itself
			// to help resolve the virtual capabilities
			$requestFactory = new WURFL_Request_GenericRequestFactory();
			$request = $requestFactory->createRequestForUserAgent($modelDevices[0]->userAgent);
			$genericNormalizer = WURFL_UserAgentHandlerChainFactory::createGenericNormalizers();
			$request->userAgentNormalized = $genericNormalizer->normalize($request->userAgent);
		}

		// The CustomDevice is not cached since virtual capabilities must be recalculated
		// for every different request.
		return new WURFL_CustomDevice($modelDevices, $request);
	}
}
