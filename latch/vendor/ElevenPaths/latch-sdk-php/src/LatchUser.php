<?php

namespace ElevenPaths\Latch;

use ElevenPaths\Latch\LatchAuth as LatchAuth;
use ElevenPaths\Latch\LatchResponse as LatchResponse;

/**
 * This class model the API for a Latch User. Every action here is related to a User. This
 * means that a LatchUser object should use a pair UserId/Secret obtained from the Latch Website.
 */
class LatchUser extends LatchAuth {

    /**
     * Create an instance of the class with the User ID and secret obtained from Eleven Paths
     * @param $userId
     * @param $secretKey
     */
    public function __construct($userId, $secretKey) {
        parent::__construct($userId, $secretKey);
    }

    public function getSubscription() {
        return $this->HTTP_GET_proxy(self::$API_SUBSCRIPTION_URL);
    }

    /**
     * @param string $name
     * @param string $twoFactor
     * @param string $lockOnRequest
     * @param string $contactPhone
     * @param string $contactEmail
     * @return LatchResponse
     */
    public function createApplication($name, $twoFactor, $lockOnRequest, $contactPhone, $contactEmail) {
        $data = array(
            'name' => urlencode($name),
            'two_factor' => urlencode($twoFactor),
            'lock_on_request' => urlencode($lockOnRequest),
            'contactEmail' => urlencode($contactEmail),
            'contactPhone' => urlencode($contactPhone)
        );
        return $this->HTTP_PUT_proxy(self::$API_APPLICATION_URL, $data);
    }

    /**
     * @param string $applicationId
     * @return LatchResponse
     */
    public function removeApplication($applicationId) {
        return $this->HTTP_DELETE_proxy(self::$API_APPLICATION_URL . "/" . $applicationId);
    }

    /**
     * @return LatchResponse
     */
    public function getApplications() {
        return $this->HTTP_GET_proxy(self::$API_APPLICATION_URL);
    }

    /**
     * @param string $applicationId
     * @param string $name
     * @param string $twoFactor
     * @param string $lockOnRequest
     * @param string $contactPhone
     * @param string $contactEmail
     * @return LatchResponse
     */
    public function updateApplication($applicationId, $name, $twoFactor, $lockOnRequest, $contactPhone, $contactEmail) {
        $data = array(
            'name' => urlencode($name),
            'two_factor' => urlencode($twoFactor),
            'lock_on_request' => urlencode($lockOnRequest),
            'contactEmail' => urlencode($contactEmail),
            'contactPhone' => urlencode($contactPhone)
        );
        return $this->HTTP_POST_proxy(self::$API_APPLICATION_URL . "/" . $applicationId, $data);
    }
}
