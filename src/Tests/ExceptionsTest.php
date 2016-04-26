<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 11/16/15
 * Time: 10:44 AM
 */

namespace Rainmakerlabs\Holler\Tests;

use PHPUnit_Framework_TestCase;
use Rainmakerlabs\Holler\Exceptions\HollerExceptions;
use Rainmakerlabs\Holler\Helper\HollerClient;
use Rainmakerlabs\Holler\Services\HollerSDK;


class ExceptionsTest extends Holler_PHPUnit_Framework_TestCase
{
    /**
     * @var HollerSDK
     */
    static $holler;

    public static function setUpBeforeClass()
    {
        self::$holler = new HollerSDK();
        Helper::setUp();
    }

    public function tearDown()
    {
        Helper::tearDown();
    }

    /*
     * private static $authenticationExceptionCode = [1004,1005];
     * private static $communicationExceptionCode = [1001,1007,1008,1009];
     * private static $invalidRequestDataExceptionCode = [400];
     * private static $modelNotFoundExceptionCode = [404];
     * private static $wrongParameterExceptionCode = [1006];
     * private static $unknownErrorExceptionCode = [1010];
     * private static $methodNotAllowExceptionCode = [405];
     * private static $permissionDenyExceptionCode = [503];
     */

    /**
     * @expectedException \Rainmakerlabs\Holler\Exceptions\InvalidRequestDataException
     */
    public function testUniqueSubscriberUsernameException()
    {
        $subscriber_model = self::$holler->subscriber();
        $subscriber_model->setEmail("tan.tam.nguye.n@rainmaker-labs.com");
        $subscriber_model->setUsername("tan.tam.nguye.n@rainmaker-labs.com");
        $subscriber_model->setPhone("84 1654466163---");
        $subscriber_model->setFirstName("Tam");
        $subscriber_model->setLastName("Nguyen");
        $subscriber_model->setIsActive(true);

//        $subscriber_info = self::$holler->subscriberInfo();
//        $subscriber_info->setGpsLongitude("100000");
//        $subscriber_info->setCountry("SG");
//        $subscriber_info->setDateOfBirth("1991-10-10")->setInterestId(11);

//        $subscriber_model->setInfo($subscriber_info);
        $subscriber = $subscriber_model->register();

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Subscriber',$subscriber);
    }

    /**
     * @expectedException \Rainmakerlabs\Holler\Exceptions\CommunicationExceptions
     */
    public function testExpectCommunicationException()
    {
        $time_to_send  = date("Y-m-d H:i:s",strtotime("+5 minutes"));
        $communication = self::$holler->communication();
        $communication->setName("Name nè ". $time_to_send );
        $communication->setDescription("this is a short description");
        $communication->setChannel('email',
            ['subject'=>'subject here '.$time_to_send,'content'=>'asdfasdf','from'=>"nghia.mai@rainmaker-labs.com"]);
//    $communication->setTime(true);
        $target = self::$holler->communicationTarget();

        $segment = self::$holler->communicationTargetSegment();
        $segment->setInterest(12);
        $segment->setAge(10,20);

        $target->setSegment($segment);

//        $communication->setTarget($target);

        $cfile = new \CURLFile('/Users/nguyentantam/Documents/workspace/RML/holler-php-sdk/tea-battery_00293536.jpg','image/jpeg','test_name.jpg');


        $cover_img = $cfile;

//    var_dump($cover_img);
//    die();
        $communication->setCoverImg($cover_img);

        $communication->setTime( date("Y-m-d H:i:s",strtotime("+5 minutes")));
//        $communication->setTime(true);
        $id =$communication->create();

//        $this->assertInternalType("int", $id);
    }



    /**
     * @expectedException \Rainmakerlabs\Holler\Exceptions\ModelNotFoundExceptions
     */
    public function testModelNotFoundException()
    {
        $communication = self::$holler->communication();

        $communication = $communication->find(113);

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Communication',$communication);

    }


    /**
     * @expectedException \Rainmakerlabs\Holler\Exceptions\PermissionDenyException
     */
    public function testPermissionDenyException()
    {
        $application = self::$holler->application()->find("89225f30f4494dd1302b52d427ab8a98640ff6e3");
//        $applications = self::$holler->application()->all();
    }


    /**
     * @expectedException \Rainmakerlabs\Holler\Exceptions\MethodNotAllowException
     */
    public function testMethodNotAllowException()
    {
        HollerClient::_request("POST","communications/113");
    }


    /**
     * @expectedException \Rainmakerlabs\Holler\Exceptions\AuthenticationException
     */
    public function testLoginSubscriber()
    {
        $subscriber = self::$holler->subscriber();
        $subscriber->login(['email'=>'test']);
    }

}