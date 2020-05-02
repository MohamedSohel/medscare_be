<?php
/**
 *  Error Constants file for Storing Error Message codes and Message Text for Application.
 *
 *  @category Constants
 *  @author Ashish Kumar<ashish.k@mindfiresolutions.com>
 */

namespace AppBundle\Constants;


final class ErrorConstants
{
    const INVALID_PHONE = 'INVALIDPASSWORD';
    const INVALID_REQ = 'INVALID_REQ';
    const INTERNAL_ERR = 'INTERNAL_ERR';
    const EXISTING_USER = 'EXISTING_USER';
    const USER_NOT_FOUND = 'USER_NOT_FOUND';
    const INVALID_OTP = 'INVALID_OTP';

    public static $errorCodeMap = [
        self::INVALID_PHONE => ['code' => '1024', 'message' => 'Invalid Phone Provided'],
        self::INVALID_REQ => ['code' => '1024', 'message' => 'Invalid Request provided'],
        self::INTERNAL_ERR => ['code' => '500', 'message' => 'Internal Server Error'],
        self::EXISTING_USER => ['code' => '1024', 'message' => 'User already registered'],
        self::INVALID_OTP => ['code' => '1024', 'message' => 'OTP Not Matched']
    ];
}
