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

class Error {

	private $code;
	private $message;

	/**
	 * 
	 * @param string $json a Json representation of an error with "code" and "message" elements
	 */
	function __construct($json) {
		$json = is_string($json)? json_decode($json) : $json;
		if(json_last_error() == JSON_ERROR_NONE){
			if(array_key_exists("code", (array) $json) && array_key_exists("message", (array) $json)) {
				$this->code = $json->{"code"};
				$this->message = $json->{"message"};
			}
		} else {
			error_log("Error creating error object from string " . $json);
		}
	}
	
	public function getCode() {
		return $this->code;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	/**
	 *
	 * @return Json representation with the code and message of the error
	 */
	public function toJson() {
		return json_encode(array(
			"code" => $this->code,
			"message" => $this->message
		));
	}
}
