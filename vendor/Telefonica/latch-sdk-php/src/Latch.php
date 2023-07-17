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

use Telefonica\Latch\LatchApp as LatchApp;

/**
 *
 * @deprecated This class is now deprecated. Use LatchApp or Latch user instead.
 */
final class Latch extends LatchApp {

    /**
     * Create an instance of the class with the Application ID and secret obtained from Telefonica Digital
     * @param $appId
     * @param $secretKey
     * @deprecated
     */
    function __construct($appId, $secretKey) {
        parent::__construct($appId, $secretKey);
    }

}
