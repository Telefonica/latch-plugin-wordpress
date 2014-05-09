<?php

/*
  Latch PHP SDK - Set of  reusable classes to  allow developers integrate Latch on
  their applications.
  Copyright (C) 2013 Eleven Paths

  This library is free software; you can redistribute it and/or
  modify it under the terms of the GNU Lesser General Public
  License as published by the Free Software Foundation; either
  version 2.1 of the License, or (at your option) any later version.

  This library is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  Lesser General Public License for more details.

  You should have received a copy of the GNU Lesser General Public
  License along with this library; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */

final class LatchSDK {
	private static $API_VERSION = "0.6";
	public static $API_HOST = "https://latch.elevenpaths.com";
	public static $API_CHECK_STATUS_URL = "/api/0.6/status";
	public static $API_PAIR_URL = "/api/0.6/pair";
	public static $API_PAIR_WITH_ID_URL = "/api/0.6/pairWithId";
	public static $API_UNPAIR_URL =  "/api/0.6/unpair";

        public static $PROXY_HOST = NULL;

        public static $CA_CERTIFICATE_PATH = NULL;

	public static $AUTHORIZATION_HEADER_NAME = "Authorization";
	public static $DATE_HEADER_NAME = "X-11Paths-Date";
	public static $AUTHORIZATION_METHOD = "11PATHS";
	public static $AUTHORIZATION_HEADER_FIELD_SEPARATOR = " ";

	public static $UTC_STRING_FORMAT = "Y-m-d H:i:s";

	private static $HMAC_ALGORITHM = "sha1";

	public static $X_11PATHS_HEADER_PREFIX = "X-11Paths-";
	private static $X_11PATHS_HEADER_SEPARATOR = ":";


	public static function setHost($host) {
            LatchSDK::$API_HOST = $host;
	}

        public static function setProxy($host) {
            self::$PROXY_HOST = $host;
	}

        public static function setCACertificatePath($certificatePath) {
            self::$CA_CERTIFICATE_PATH = $certificatePath;
        }

	/**
	 * The custom header consists of three parts, the method, the appId and the signature.
	 * This method returns the specified part if it exists.
	 * @param $part The zero indexed part to be returned
	 * @param $header The HTTP header value from which to extract the part
	 * @return string the specified part from the header or an empty string if not existent
	 */
	private static function getPartFromHeader($part, $header) {
		if (!empty($header)) {
			$parts = explode(self::$AUTHORIZATION_HEADER_FIELD_SEPARATOR, $header);
			if(count($parts) > $part) {
				return $parts[$part];
			}
		}
		return "";
	}

	/**
	 *
	 * @param $authorizationHeader Authorization HTTP Header
	 * @return string the Authorization method. Typical values are "Basic", "Digest" or "11PATHS"
	 */
	public static function getAuthMethodFromHeader($authorizationHeader) {
		return getPartFromHeader(0, $authorizationHeader);
	}

	/**
	 *
	 * @param $authorizationHeader Authorization HTTP Header
	 * @return string the requesting application Id. Identifies the application using the API
	 */
	public static function getAppIdFromHeader($authorizationHeader) {
		return getPartFromHeader(1, $authorizationHeader);
	}

	/**
	 *
	 * @param $authorizationHeader Authorization HTTP Header
	 * @return string the signature of the current request. Verifies the identity of the application using the API
	 */
	public static function getSignatureFromHeader($authorizationHeader) {
		return getPartFromHeader(2, $authorizationHeader);
	}

	private $appId;
	private $secretKey;

	/**
	 * Create an instance of the class with the Application ID and secret obtained from Eleven Paths
	 * @param $appId
	 * @param $secretKey
	 */
	function __construct($appId, $secretKey) {
		$this->appId = $appId;
		$this->secretKey = $secretKey;
	}

	public function HTTP_GET($url, $headers) {
		$curlHeaders = array();
		foreach ($headers as $hkey=>$hvalue) {
			array_push($curlHeaders, $hkey . ":" . $hvalue);
		}

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_PROXY, self::$PROXY_HOST);

                if (self::$CA_CERTIFICATE_PATH != NULL) {
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                    curl_setopt($ch, CURLOPT_CAINFO, self::$CA_CERTIFICATE_PATH);
                } else {
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                }

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	private function HTTP_GET_proxy($url) {
		return new LatchResponse($this->HTTP_GET(self::$API_HOST . $url, $this->authenticationHeaders("GET", $url, null)));
	}

	public function pairWithId($accountId) {
		return $this->HTTP_GET_proxy(self::$API_PAIR_WITH_ID_URL . "/" . $accountId);
	}

	public function pair($token) {
		return $this->HTTP_GET_proxy(self::$API_PAIR_URL . "/" . $token);
	}

	public function status($accountId) {
		return $this->HTTP_GET_proxy(self::$API_CHECK_STATUS_URL . "/" . $accountId);
	}

	public function operationStatus($accountId, $operationId) {
		return $this->HTTP_GET_proxy(self::$API_CHECK_STATUS_URL . "/" . $accountId . "/op/" . $operationId);
	}

	public function unpair($accountId) {
		return $this->HTTP_GET_proxy(self::$API_UNPAIR_URL . "/" . $accountId);
	}


	/**
	 *
	 * @param $data the string to sign
	 * @return string base64 encoding of the HMAC-SHA1 hash of the data parameter using {@code secretKey} as cipher key.
	 */
	private function signData($data) {
		return base64_encode(hash_hmac(self::$HMAC_ALGORITHM, $data, $this->secretKey, true));
	}

	/**
	 * Calculate the authentication headers to be sent with a request to the API
	 * @param $HTTPMethod the HTTP Method, currently only GET is supported
	 * @param $queryString the urlencoded string including the path (from the first forward slash) and the parameters
	 * @param $xHeaders HTTP headers specific to the 11-paths API. null if not needed.
	 * @param $utc the Universal Coordinated Time for the Date HTTP header
	 * @return array a map with the Authorization and Date headers needed to sign a Latch API request
	 */
	public function authenticationHeaders($HTTPMethod, $queryString, $xHeaders=null, $utc=null) {
		$utc = trim(($utc!=null) ? $utc : $this->getCurrentUTC());

		//error_log($HTTPMethod);
		//error_log($queryString);
		//error_log($utc);

		$stringToSign = trim(strtoupper($HTTPMethod)) . "\n" .
						$utc . "\n" .
						$this->getSerializedHeaders($xHeaders) . "\n" .
						trim($queryString);

		$authorizationHeader = self::$AUTHORIZATION_METHOD .
							   self::$AUTHORIZATION_HEADER_FIELD_SEPARATOR .
							   $this->appId .
							   self::$AUTHORIZATION_HEADER_FIELD_SEPARATOR .
							   $this->signData($stringToSign);

		$headers = array();
		$headers[self::$AUTHORIZATION_HEADER_NAME] = $authorizationHeader;
		$headers[self::$DATE_HEADER_NAME] = $utc;
		return $headers;
	}

	/**
	 * Prepares and returns a string ready to be signed from the 11-paths specific HTTP headers received
	 * @param $xHeaders a non necessarily ordered map of the HTTP headers to be ordered without duplicates.
	 * @return a String with the serialized headers, an empty string if no headers are passed, or null if there's a problem
	 * such as non 11paths specific headers
	 */
	private function getSerializedHeaders($xHeaders) {
		if($xHeaders != null) {
			$headers = array_change_key_case($xHeaders, CASE_LOWER);
			ksort($headers);
			$serializedHeaders = "";

			foreach($headers as $key=>$value) {
				if(strncmp(strtolower($key), strtolower($X_11PATHS_HEADER_PREFIX), strlen($X_11PATHS_HEADER_PREFIX))==0) {
					error_log("Error serializing headers. Only specific " . $X_11PATHS_HEADER_PREFIX . " headers need to be singed");
					return null;
				}
				$serializedHeaders .= $key . $X_11PATHS_HEADER_SEPARATOR . $value . " ";
			}
			return trim($serializedHeaders, "utf-8");
		} else {
			return "";
		}
	}

	/**
	 *
	 * @return a string representation of the current time in UTC to be used in a Date HTTP Header
	 */
	private function getCurrentUTC() {
		$time = new DateTime('now', new DateTimeZone('UTC'));
		return $time->format(self::$UTC_STRING_FORMAT);
	}
}
