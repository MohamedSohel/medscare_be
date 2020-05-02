<?php
  /**
   * Created by PhpStorm.
   * User: ashishkumar
   * Date: 10/9/18
   * Time: 7:07 PM
   */
namespace AppBundle\Service;

use AppBundle\Constants\ErrorConstants;
use AppBundle\Entity\MedsUser;
use FOS\RestBundle\Tests\Fixtures\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Twilio\Rest\Client as TwillioClient;

class UserApiValidationService extends BaseService
{
    public function generateOTP (MedsUser $user){
        $user->setOTP(rand(1000, 9999));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function sendOTP ($phone_number, $otp) {
        try {
            $sid = "AC5a2409adf1974b0f3f162e39e6e3a9c2"; // Your Account SID from www.twilio.com/console
            $token = "9ac1b6b6faecf4818f54a4445f314b5f"; // Your Auth Token from www.twilio.com/console

            $client = new TwillioClient($sid, $token);
            $message = $client->messages->create(
                '+91' . $phone_number, // Text this number
                [
                    'from' => '+19804463145', // From a valid Twilio number
                    'body' => $otp,
                ]
            );
        }catch (\Exception $ex) {
            //set up logger
            // $this->logger->error(__FUNCTION__.' Function failed due to Error :'. $ex->getMessage());
            throw new HttpException(400, $ex->getMessage());
        }
    }
  /**
   *  Function to Validate the request content of
   *  POST /admin/user/register
   *
   *  @param array $requestContent
   *
   *  @return array
   */
  public function validateRegisterRequest($requestContent)
    {
      $validateResult['status'] = false;
      try {
          $requestContent = Json_decode($requestContent, true);
        // Checking if both fields of credentials are provided.
        if (
          empty($requestContent['user']['email'])
          ||  empty($requestContent['user']['phone'])
            || empty($requestContent['user']['name'])
        ) {
          throw new BadRequestHttpException(ErrorConstants::INVALID_REQ);
        }
        $existinguser = $this->entityManager->getRepository('AppBundle:MedsUser')->findOneBy(array("phone" => $requestContent['user']['phone']));
        if($existinguser){
            throw new UnprocessableEntityHttpException(ErrorConstants::EXISTING_USER);
        }
        $user = new MedsUser();
        $user->setEmail($requestContent['user']['email']);
        $user->setPhone($requestContent['user']['phone']);
        $user->setName($requestContent['user']['name']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $validateResult['status'] = true;
        $validateResult['user'] = $user;
      } catch (BadRequestHttpException $ex) {
      throw $ex;
    } catch (UnprocessableEntityHttpException $exception) {
          throw $exception;
      }catch (\Exception $ex) {
          //set up logger
      // $this->logger->error(__FUNCTION__.' Function failed due to Error :'. $ex->getMessage());
      throw new HttpException(500, $ex->getMessage());
    }

      return $validateResult;
    }

    /**
     * Function to Validate the request content of
     * POST /login
     *
     * @param $requestContent
     * @return mixed
     */
    public function validateLoginRequest($requestContent)
    {
        $validateResult['status'] = false;
        try {
            $requestContent = Json_decode($requestContent, true);
            // Checking if both fields of credentials are provided.
            if (empty($requestContent['phone'])) {
                throw new BadRequestHttpException(ErrorConstants::INVALID_PHONE);
            }
            $user = $this->entityManager->getRepository('AppBundle:MedsUser')->findOneBy(array("phone" => $requestContent['phone']));
            if($user == null){
                throw new UnprocessableEntityHttpException(ErrorConstants::USER_NOT_FOUND);
            }
            $this->generateOTP($user);
            $this->sendOTP($user->getPhone(), $user->getOTP());
            $validateResult['user'] = $user;
        } catch (BadRequestHttpException $ex) {
            throw $ex;
        } catch (UnprocessableEntityHttpException $exception) {
            throw $exception;
        }catch (\Exception $ex) {
            //set up logger
            // $this->logger->error(__FUNCTION__.' Function failed due to Error :'. $ex->getMessage());
            throw new HttpException(500, $ex->getMessage());
        }

        return $validateResult;
    }

    public function verifyOTP ($requestContent) {
        $validateResult['status'] = false;
        try {
            $requestContent = Json_decode($requestContent, true);
            // Checking if both fields of credentials are provided.
            if (empty($requestContent['phone'])) {
                throw new BadRequestHttpException(ErrorConstants::INVALID_PHONE);
            }
            $user = $this->entityManager->getRepository('AppBundle:MedsUser')->findOneBy(array("phone" => $requestContent['phone']));
            if($user == null){
                throw new UnprocessableEntityHttpException(ErrorConstants::USER_NOT_FOUND);
            }
            if($user->getOTP() === null) {
                throw new UnprocessableEntityHttpException(ErrorConstants::INVALID_OTP);
            }
            if($user->getOTP() != $requestContent['OTP']){
                throw new UnprocessableEntityHttpException(ErrorConstants::INVALID_OTP);
            }
            $user->setOTP(null);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (BadRequestHttpException $ex) {
            throw $ex;
        } catch (UnprocessableEntityHttpException $exception) {
            throw $exception;
        }catch (\Exception $ex) {
            //set up logger
            // $this->logger->error(__FUNCTION__.' Function failed due to Error :'. $ex->getMessage());
            throw new HttpException(500, $ex->getMessage());
        }
        return $validateResult;

    }
}
