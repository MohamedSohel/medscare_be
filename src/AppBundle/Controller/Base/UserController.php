<?php


namespace AppBundle\Controller\Base;

use AppBundle\Constants\ErrorConstants;
use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserController extends FOSRestBundle
{
    /**
     * @param Request $request
     * @return |null
     * @Post("/register", name="oauth_validate_post")
     */
    public function RegisterUser(Request $request)
    {
        $response = null;
        try {
           $userValidator = $this->container
                ->get('medscare.user_validate_service');
           $validationStatus = $userValidator->validateRegisterRequest($request->getContent());
           $response = $this->container
                ->get('medscare.api_response')
                ->createApiSuccessResponse('user', $validationStatus);
        } catch (BadRequestHttpException $exception) {
            throw $exception;
        } catch (UnprocessableEntityHttpException $exception) {
            throw $exception;
        } catch (HttpException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            // Throwing Internal Server Error Response In case of Unknown Errors.
            throw new HttpException(500, $exception);
        }
        return new JsonResponse($response);
    }
    /**
     * @param Request $request
     * @return |null
     * @Post("/login", name="oauth_validate_post")
     */
    public function LoginUser(Request $request)
    {
        $response = null;
        try {
            $userValidator = $this->container
                ->get('medscare.user_validate_service');
            $validationStatus = $userValidator->validateLoginRequest($request->getContent());
            dump($validationStatus['user']);
            $response = $this->container
                ->get('medscare.api_response')
                ->createApiSuccessResponse('user', $validationStatus['user']);
        } catch (BadRequestHttpException $exception) {
            throw $exception;
        } catch (UnprocessableEntityHttpException $exception) {
            throw $exception;
        } catch (HttpException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            // Throwing Internal Server Error Response In case of Unknown Errors.
            throw new HttpException(500, $exception);
        }
        return new JsonResponse($response);
    }

    /**
     * @param Request $request
     * @return |null
     * @Post("/verifyotp")
     */
    public function VerifyOTP(Request $request)
    {
        $response = null;
        try {
            $userValidator = $this->container
                ->get('medscare.user_validate_service');
            $validationStatus = $userValidator->verifyOTP($request->getContent());
            $response = $this->container
                ->get('medscare.api_response')
                ->createApiSuccessResponse('user', 'Verified');
        } catch (BadRequestHttpException $exception) {
            throw $exception;
        } catch (UnprocessableEntityHttpException $exception) {
            throw $exception;
        } catch (HttpException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            // Throwing Internal Server Error Response In case of Unknown Errors.
            throw new HttpException(500, $exception);
        }
        return new JsonResponse($response);
    }

}
