<?php

/**
 * Exception listener class for the kernel exceptions
 *
 * @author Ashish Kumar
 *
 * @category Listener
 *
 */
namespace AppBundle\EventListener;

use AppBundle\Service\BaseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;


class ExceptionListener extends BaseService
{
    /**
     * Function for handling exceptions
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        /*$status = method_exists($event->getException(), 'getStatusCode')
            ? $event->getException()->getStatusCode()
            : 500;

        $transactionId = null;
        $exceptionMessage = $event->getException()->getMessage();

        if (!is_array($exceptionMessage) && !in_array($exceptionMessage, array_keys(ErrorConstants::$errorCodeMap))) {
            // Log the Exception Not thrown from controllers because other have been logged Already in controllers.
            $this->logger->error("Error",
                [
                    $status => $event->getException()->getMessage(),
                    'TRACE' => $event->getException()->getTraceAsString()
                ]
            );

        } elseif (is_array($exceptionMessage)) {
            $transactionId = $exceptionMessage['transactionId'];
            $exceptionMessage = $exceptionMessage['error'];
        }*/

        /*switch ($status) {
            case 400:
                $messageKey = $exceptionMessage;
                break;
            case 401:
                $messageKey = $exceptionMessage;
                break;
            case 403:
                $messageKey = ErrorConstants::INVALID_AUTHORIZATION;
                break;
            case 404:
                $messageKey = ErrorConstants::RESOURCE_NOT_FOUND;
                break;
            case 405:
                $messageKey = ErrorConstants::METHOD_NOT_ALLOWED;
                break;
            case 408:
                $messageKey = ErrorConstants::REQ_TIME_OUT;
                break;
            case 409:
                $messageKey = $exceptionMessage;
                break;
            case 422:
                $messageKey = $exceptionMessage;
                break;
            case 500:
                $messageKey = ErrorConstants::INTERNAL_ERR;
                break;
            case 502:
                $messageKey = $exceptionMessage;
                break;
            case 503:
                $messageKey = ErrorConstants::SERVICE_UNAVAIL;
                break;
            case 504:
                $messageKey = ErrorConstants::GATEWAY_TIMEOUT;
                break;
            default :
                $messageKey = ErrorConstants::INTERNAL_ERR;
                break;
        }*/
        $responseService = $this->serviceContainer->get('medscare.api_response');
        // Creating Http Error response.
        $result = $responseService->createApiErrorResponse($event->getException()->getMessage());
        $response = new JsonResponse($result);
        // Logging Exception in Exception log.
        /*$this->logger->error('RDN B2BEload Exception :', [
            'Response' => [
                'Headers' => $response->headers->all(),
                'Content' => $response->getContent()
            ]
        ]);*/
        $event->setResponse($response);
    }
}
