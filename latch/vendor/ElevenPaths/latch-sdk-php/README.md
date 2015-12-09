### LATCH PHP SDK ###


#### PREREQUISITES ####

* PHP 5.3 or above.

* Read API documentation (https://latch.elevenpaths.com/www/developers/doc_api).

* To get the "Application ID" and "Secret", (fundamental values for integrating Latch in any application), it’s necessary to register a developer account in Latch's website: https://latch.elevenpaths.com. On the upper right side, click on "Developer area".


#### USING THE SDK IN PHP ####

* Require "latch" sdk. Keep in mind to set the path properly according to your server.
```
	require_once("latch/Latch.php");
     require_once("latch/LatchResponse.php");
     require_once("latch/Error.php");
```

* Create a Latch object with the "Application ID" and "Secret" previously obtained.
```
	$api = new Latch(APP_ID, APP_SECRET);
```

* Optional settings:
```
	$api->setProxy(YOUR_PROXY);
```

* Call to Latch Server. Pairing will return an account id that you should store for future api calls
```
     $pairResponse = $api->pair("PAIRING_CODE_HERE");
     $statusResponse = $api->status(ACCOUNT_ID_HERE);
     $unpairResponse = $api->unpair(ACCOUNT_ID_HERE);
```

* After every API call, get Latch response data and errors and handle them.
```
     $pairResponse->getData();
     $pairResponse->getError();
```
