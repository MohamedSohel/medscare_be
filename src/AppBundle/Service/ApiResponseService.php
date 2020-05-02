<?php
/**
 *  Service Class for Creating API Request Response.
 *
 *  @category Service
 *  @author Sohel
 */
namespace AppBundle\Service;



use AppBundle\Constants\ErrorConstants;

class ApiResponseService extends BaseService
{
    /**
     *  Function to create API Error Response.
     *
     *  @param string $errorCode
     *
     *  @return array
     */
    public function createApiErrorResponse($errorCode)
    {
        $response = [
            'reasonCode' => ErrorConstants::$errorCodeMap[$errorCode]['code'],
            'reasonText' =>  ErrorConstants::$errorCodeMap[$errorCode]['message'],
        ];
        return $response;
    }

    public function createApiSuccessResponse($responseKey, $data)
    {
        return [
            'reasonCode' => '0',
            'reasonText' => 'Success',
            $responseKey => $data,
        ];
    }
}
