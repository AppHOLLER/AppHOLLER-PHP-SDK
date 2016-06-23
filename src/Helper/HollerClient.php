<?php namespace Rainmakerlabs\Holler\Helper;

/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 11/13/15
 * Time: 2:08 PM
 */
use Exception;
use Rainmakerlabs\Holler\Exceptions\AuthenticationException;
use Rainmakerlabs\Holler\Exceptions\CommunicationExceptions;
use Rainmakerlabs\Holler\Exceptions\HollerExceptions;
use Rainmakerlabs\Holler\Exceptions\InvalidRequestDataException;
use Rainmakerlabs\Holler\Exceptions\MethodNotAllowException;
use Rainmakerlabs\Holler\Exceptions\ModelNotFoundExceptions;
use Rainmakerlabs\Holler\Exceptions\PermissionDenyException;
use Rainmakerlabs\Holler\Exceptions\UnknownErrorHollerExceptions;
use Rainmakerlabs\Holler\Exceptions\WrongParameterException;

/**
 * ParseClient - Main class for Parse initialization and communication.
 *
 * @author Fosco Marotto <fjm@fb.com>
 */
final class HollerClient
{
    /**
     * Constant for the API Server Host Address.
     */
    const API_URL = 'http://staging.holler.rainmaker-labs.com/api';//'http://appholler.com/api';

    /**
     * Constant for the API Service version.
     */
    const API_VERSION = '1.0';


    /**
     * application id on Holler
     *
     * @var string
     */
    private static $applicationId;

    /**
     * access token of user to access to Holler
     *
     * @var string
     */
    private static $accessToken;


    private static $masterToken;

    /**
     * @return mixed
     */
    public static function getMasterToken()
    {
        return self::$masterToken;
    }

    /**
     * @param mixed $masterToken
     */
    public static function setMasterToken($masterToken)
    {
        self::$masterToken = $masterToken;
    }

    /**
     * SDK will log arguments or not
     * @var boolean
     */
    private static $debugMode;

    /**
     * SDK will throw exception or not
     * @var boolean
     */
    private static $silentMode;

    private static $timeout = 100;
    private static $connectionTimeout = 100;


    private static $authenticationExceptionCode = [1004, 1005];
    private static $communicationExceptionCode = [1001, 1007, 1008, 1009];
    private static $invalidRequestDataExceptionCode = [400];
    private static $modelNotFoundExceptionCode = [404];
    private static $wrongParameterExceptionCode = [1006];
    private static $unknownErrorExceptionCode = [1010];
    private static $methodNotAllowExceptionCode = [405];
    private static $permissionDenyExceptionCode = [403];


    /**
     * initialize Holler SDK to setup all necessary information to send request
     *
     * @param $application_id
     * @param $access_token
     * @param bool|false $debug_model
     * @param bool|false $silent_mode
     */
    public static function initialize($application_id, $access_token, $debug_model = false, $silent_mode = false)
    {

        self::setApplicationId($application_id);
        self::setAccessToken($access_token);

        // log arguments for testing purpose or not
        self::setDebugMode($debug_model);

        // throw exception or just return false
        self::setSilentMode($silent_mode);
    }

    /**
     * @return mixed
     */
    public static function getApplicationId()
    {
        return self::$applicationId;
    }

    /**
     * @param mixed $applicationId
     */
    public static function setApplicationId($applicationId)
    {
        self::$applicationId = $applicationId;
    }

    /**
     * @return mixed
     */
    public static function getAccessToken()
    {
        return self::$accessToken;
    }

    /**
     * @param mixed $accessToken
     */
    public static function setAccessToken($accessToken)
    {
        self::$accessToken = $accessToken;
    }

    /**
     *
     * @return mixed
     */
    public static function getDebugMode()
    {
        return self::$debugMode;
    }

    /**
     * @param mixed $debugMode
     */
    public static function setDebugMode($debugMode)
    {
        self::$debugMode = $debugMode;
    }

    /**
     * @return mixed
     */
    public static function getSilentMode()
    {
        return self::$silentMode;
    }

    /**
     *
     * @param mixed $silentMode
     */
    public static function setSilentMode($silentMode)
    {
        self::$silentMode = $silentMode;
    }

    /**
     * Get remote Holler API url.
     *
     * @return string
     */
    public static function getAPIUrl()
    {
        return self::API_URL . '/';
    }


    protected static function debug($data)
    {

        $data = is_string($data) ? $data : json_encode($data);
        if (self::getDebugMode()) {
            if(class_exists('Log')){
                \Log::debug($data);
            }else{
            error_log($data);
        }
    }
    }


    /**
     * @param $method
     * @param $relativeUrl
     * @param null $data
     * @return object | boolean | mixed
     * @throws Exception
     * @throws HollerExceptions
     */
    public static function _request(
        $method,
        $relativeUrl,
        $data = null
    )
    {


        self::debug(func_get_args());


        self::assertHollerInitialized();
        $headers = self::getRequestHeaders();

        self::debug($headers);

        $url = self::getAPIUrl() . ltrim($relativeUrl, '/');

        if ($method === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        if (!is_string($data)) {
            $data_json = json_encode($data);
        } else {
            $data_json = $data;
        }
//		if ($data === '[]') {
//			$data = '{}';
//		}

//		$data = http_build_query($data);

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $url);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        if ($method === 'POST') {
            $headers[] = 'Content-Type: application/json';
            curl_setopt($rest, CURLOPT_POST, 1);
            curl_setopt($rest, CURLOPT_POSTFIELDS, $data_json);
        }

        if ($method === 'POST_WITH_FILE') {
//			$headers[] = 'Content-Type: multipart/form-data';
            curl_setopt($rest, CURLOPT_POST, 1);
            curl_setopt($rest, CURLOPT_POSTFIELDS, $data);
        }
        if ($method === 'PUT') {
            $headers[] = 'Content-Type: application/json';
            curl_setopt($rest, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($rest, CURLOPT_POSTFIELDS, $data_json);
        }


        if ($method === 'PUT_WITH_FILE') {
//			$headers[] = 'Content-Type: multipart/form-data';
            curl_setopt($rest, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($rest, CURLOPT_POSTFIELDS, $data);
        }

        if ($method === 'DELETE') {
            curl_setopt($rest, CURLOPT_CUSTOMREQUEST, $method);
        }
        curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);

        if (!is_null(self::$connectionTimeout)) {
            curl_setopt($rest, CURLOPT_CONNECTTIMEOUT, self::$connectionTimeout);
        }
        if (!is_null(self::$timeout)) {
            curl_setopt($rest, CURLOPT_TIMEOUT, self::$timeout);
        }

        curl_setopt($rest, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($rest, CURLOPT_TIMEOUT, 400); //timeout in seconds

        $response = curl_exec($rest);
        $status = curl_getinfo($rest, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($rest, CURLINFO_CONTENT_TYPE);
        if (curl_errno($rest)) {
            throw new HollerExceptions(curl_error($rest), curl_errno($rest));
        }

        curl_close($rest);

        if (FALSE == $response)
            throw new HollerExceptions(curl_error($rest), curl_errno($rest));

        if (strpos($contentType, 'text/html') !== false
//			&& !self::getSilentMode()
        ) {
            $data_string = is_string($data) ? $data : json_encode($data);
            $exception = new HollerExceptions('Status: ' . ($status) . ' - Bad Request. ' . $data_string, -1);
            $exception->setResponseData($response);
            $exception->setApiRequest($relativeUrl);
            $exception->setMethodRequest($method);
            $exception->setParameterRequest($data);
            throw $exception;
        }

        $decoded = json_decode($response, false);

        if ($decoded) {
            // log return data
            self::debug($decoded);
        }

        self::validateErrorExceptionRequest($decoded, $relativeUrl, $data);

        return $decoded;
    }


    /**
     * @param $data_response
     * @param $method
     * @param $relativeUrl
     * @param null $data
     * @throws HollerExceptions
     */
    public static function validateErrorExceptionRequest($data_response, $method,
                                                         $relativeUrl,
                                                         $data = null)
    {

        /**
         * private static $authenticationExceptionCode = [1004,1005];
         * private static $communicationExceptionCode = [1001,1007,1008,1009];
         * private static $invalidRequestDataExceptionCode = [400];
         * private static $modelNotFoundExceptionCode = [404];
         * private static $wrongParameterExceptionCode = [1006];
         * private static $unknownErrorExceptionCode = [1010];
         * private static $methodNotAllowExceptionCode = [405];
         * private static $permissionDenyExceptionCode = [503];
         */

        if (!self::getSilentMode() && isset($data_response->error) && $data_response->error == true) {
            $message = json_encode($data_response);//is_string($data_response->detail)?$data_response->detail:json_encode($data_response->detail);

            $status_code = $data_response->status_code;
            if (in_array($status_code, self::$authenticationExceptionCode)) {
                $exception = new AuthenticationException($message, $status_code);
            } elseif (in_array($status_code, self::$communicationExceptionCode)) {
                $exception = new CommunicationExceptions($message, $status_code);
            } elseif (in_array($status_code, self::$invalidRequestDataExceptionCode)) {
                $exception = new InvalidRequestDataException($message, $status_code);
            } elseif (in_array($status_code, self::$modelNotFoundExceptionCode)) {
                $exception = new ModelNotFoundExceptions($message, $status_code);
            } elseif (in_array($status_code, self::$wrongParameterExceptionCode)) {
                $exception = new WrongParameterException($message, $status_code);
            } elseif (in_array($status_code, self::$unknownErrorExceptionCode)) {
                $exception = new UnknownErrorHollerExceptions($message, $status_code);
            } elseif (in_array($status_code, self::$methodNotAllowExceptionCode)) {
                $exception = new MethodNotAllowException($message, $status_code);
            } elseif (in_array($status_code, self::$permissionDenyExceptionCode)) {
                $exception = new PermissionDenyException($message, $status_code);
            } else {
                $exception = new HollerExceptions($message, $status_code);
            }
            $exception->setResponseData($data_response);
            $exception->setApiRequest($relativeUrl);
            $exception->setMethodRequest($method);
            $exception->setParameterRequest($data);
            throw $exception;
        }
    }


    /**
     * @throws HollerExceptions
     */
    private static function assertHollerInitialized()
    {
        if (self::getAccessToken() === null) {
            throw new HollerExceptions(
                'You must call HollerClient::initialize() before making any requests.'
            );
        }
    }

    /**
     * @return array
     */
    public static function getRequestHeaders()
    {
        $headers = ['HOLLER-APP-ID: ' . self::getApplicationId(),
//			'Content-Type: application/json',
        ];

        if ($masterToken = self::getMasterToken()) {
            $headers[] = "Authorization:Token " . $masterToken;
        } elseif ($getAccessToken = self::getAccessToken()) {
            $headers[] = "HOLLER-ACCESS-KEY: " . self::getAccessToken();
        }

        /*
         * Set an empty Expect header to stop the 100-continue behavior for post
         *     data greater than 1024 bytes.
         *     http://pilif.github.io/2007/02/the-return-of-except-100-continue/
         */
        $headers[] = 'Expect: ';

        return $headers;
    }


}
