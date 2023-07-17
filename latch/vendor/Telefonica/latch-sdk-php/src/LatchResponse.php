<?php

/*
  Latch PHP SDK - Set of  reusable classes to  allow developers integrate Latch on
  their applications.
  Copyright (C) 2023 Telefonica Digital

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

namespace Telefonica\Latch;

use Telefonica\Latch\Error as Error;

/**
 * This class models a response from any of the endpoints in the Latch API.
 * It consists of a "data" and an "error" elements. Although normally only one of them will be
 * present, they are not mutually exclusive, since errors can be non fatal, and therefore a response
 * could have valid information in the data field and at the same time inform of an error.
 *
 */
class LatchResponse {

	public $data = null;
	public $error = null;

    /**
     *
     * @param $jsonString
     * @internal param a $json json string received from one of the methods of the Latch API
     */
	public function __construct($jsonString) {
		$json = json_decode($jsonString);
		if(!is_null($json)) {
			if (array_key_exists("data", (array) $json)) {
				$this->data = $json->{"data"};
			}
			if (array_key_exists("error", (array) $json)) {
				$this->error = new Error($json->{"error"});
			} 
		}
	}
	
	/**
	 *
	 * @return JSONObject the data part of the API response
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 *
	 * @param $data the data to include in the API response
	 */
	public function setData($data) {
		$this->data = json_decode($data);
	}

	/**
	 * 
	 * @return Error the error part of the API response, consisting of an error code and an error message
	 */
	public function getError() {
		return $this->error;
	}

	/**
	 *
	 * @param $error an error to include in the API response
	 */
	public function setError($error) {
		$this->error = new Error($error);
	}

	/**
	 *
	 * @return JsonObject a Json object with the data and error parts set if they exist
	 */
	public function toJSON() {
		$response = array();
		if(!empty($this->data)) {
			$response["data"] = $this->data;
		}
		
		if(!empty($error)) {
			$response["error"] = $this->error;
		} 
		return json_encode($response);
	}
}