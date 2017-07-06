# ScientiaMobile WURFL PHP API #

- http://www.scientiamobile.com/
- http://wurfl.sourceforge.com/

----------

# LICENSE #
This program is free software: you can redistribute it and/or modify it under
the terms of the GNU Affero General Public License as published by the Free
Software Foundation, either version 3 of the License, or (at your option) any
later version.

Please refer to the COPYING file distributed with this package for the
complete text of the applicable GNU Affero General Public License.

If you are not able to comply with the terms of the AGPL license, commercial
licenses are available from ScientiaMobile, Inc at http://www.ScientiaMobile.com/

# Getting Started #
Download a release archive from wurfl site and extract it to a directory 
suitable for your application.

To start using the API you need to set some configuration options.

> __IMPORTANT__: The WURFL API is closely tied to the WURFL.XML file.  New versions of the WURFL.XML are compatible with old versions of the API by nature, but the reverse is NOT true.  Old versions of the WURFL.XML are NOT guarenteed to be compatible with new versions of the API.  Let's restate that: This API is NOT compatible with old versions of the WURFL.XML.  The oldest copy of WURFL that can be used with this API is included in this distribution.

### For the impatient ones ###
Please look sample of the configuration files in examples/demo/ directory.

```php
$wurflDir = dirname(__FILE__) . '/../../../WURFL';
$resourcesDir = dirname(__FILE__) . '/../../resources';

require_once $wurflDir.'/Application.php';

$persistenceDir = $resourcesDir.'/storage/persistence';
$cacheDir = $resourcesDir.'/storage/cache';

// Create WURFL Configuration
$wurflConfig = new WURFL_Configuration_InMemoryConfig();

// Set location of the WURFL File
$wurflConfig->wurflFile($resourcesDir.'/wurfl.zip');

// Set the match mode for the API ('performance' or 'accuracy')
$wurflConfig->matchMode('performance');

// Setup WURFL Persistence
$wurflConfig->persistence('file', array('dir' => $persistenceDir));

// Setup Caching
$wurflConfig->cache('file', array('dir' => $cacheDir, 'expiration' => 36000));

// Create a WURFL Manager Factory from the WURFL Configuration
$wurflManagerFactory = new WURFL_WURFLManagerFactory($wurflConfig);

// Create a WURFL Manager
/* @var $wurflManager WURFL_WURFLManager */
$wurflManager = $wurflManagerFactory->create();
```

Now you can use some of the `WURFL_WURFLManager` class methods;

```php
$device = $wurflManager->getDeviceForHttpRequest($_SERVER);
$device->getCapability("is_wireless_device");
$device->getVirtualCapability("is_smartphone");
```

## Create a configuration object ##

1. Set the paths to the location of the main WURFL file
    (you can use zip files if you have the zip extension enabled)

2. Configure the Persistence provider by specifying the provider
	and the extra parameters needed to initialize the provider.
	The API supports the following mechanisms:
	- Memcache (http://uk2.php.net/memcache)
	- APC (Alternative PHP Cache http://www.php.net/apc)
	- MySQL
	- Memory
	- File

3. Configure the Cache provider by specifying the provider 
	and the extra parameters needed to initialize the provider.
	The API supports the following caching mechanisms:
	- Memcache (http://uk2.php.net/memcache)
	- APC (Alternative PHP Cache http://www.php.net/apc)
	- File
	- Null (no caching)

### Example Configuration ###
```php
// Create WURFL Configuration
$wurflConfig = new WURFL_Configuration_InMemoryConfig();
// Set location of the WURFL File
$wurflConfig->wurflFile($resourcesDir.'/wurfl.zip');
// Set the match mode for the API ('performance' or 'accuracy')
$wurflConfig->matchMode('performance');
// Setup WURFL Persistence
$wurflConfig->persistence('file', array('dir' => $persistenceDir));
// Setup Caching
$wurflConfig->cache('file', array('dir' => $cacheDir, 'expiration' => 36000));
```

## Using the WURFL PHP API ##

### Getting the device ###

You have four methods for retrieving a device:

1. `getDeviceForRequest(WURFL_Request_GenericRequest $request)`
	where a WURFL_Request_GenericRequest is an object which encapsulates
	userAgent, ua-profile, support for xhtml of the device.

2. `getDeviceForHttpRequest($_SERVER)`
	Most of the time you will use this method, and the API will create the
	the WURFL_Request_GenericRequest object for you	

3. `getDeviceForUserAgent(string $userAgent)`
    Used to query the API for a given User Agent string

4. `getDevice(string $deviceID)`
    Gets the device by its device ID (ex: `apple_iphone_ver1`)
	
Usage example:
```php
$device = $wurflManager->getDeviceForHttpRequest($_SERVER);
```

### Getting the device properties and its capabilities ###

The properties Device ID and Fall Back Device ID are properties of the device:

```php
$deviceID = $device->id;
$fallBack = $device->fallBack;
```

To get the value of a capability, use `getCapability()`:

```php
$value = $device->getCapability("is_tablet");
$allCaps = $device->getAllCapabilities();
```

To get the value of a virtual capability, use `getVirtualCapability()`:

```php
$value = $device->getVirtualCapability("is_smartphone");
$allVCaps = $device->getAllVirtualCapabilities();
```

### Useful Methods ###
The root WURFL device object has some useful functions:

```php
/* @var $device WURFL_CustomDevice */
$device = $wurflManager->getDeviceForHttpRequest($_SERVER);

/* @var $root WURFL_Xml_ModelDevice */
$root = $device->getRootDevice();

$group_names = $root->getGroupNames();
$cap_names = $root->getCapNames();
$defined = $root->isCapabilityDefined("foobar");
```
			

### WURFL Reloader ###
WURFL can update the persistence data automatically without any configuration
by checking the modification time of the WURFL file.  To enable, set 
allow-reload to true in the config:

```php
$wurflConfig->allowReload(true);
```

If you have any questions, please take a look at the documentation on http://wurfl.sourceforge.net,
and/or the ScientiaMobile Support Forum at http://www.scientiamobile.com/forum

