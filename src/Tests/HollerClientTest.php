<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 11/16/15
 * Time: 10:44 AM
 */

namespace Rainmakerlabs\Holler\Tests;

use PHPUnit_Framework_TestCase;
use Rainmakerlabs\Holler\Services\HollerSDK;


class HollerClientTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testApplicationAndAccessKeyIsValid()
    {
        $data = self::$holler->gender()->all();
        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Gender',$data);
    }

//    public function testTargetModel()
//    {
//        $get_all_target = self::$holler->target()->get();
//        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Target',$get_all_target);
//    }
//
//    public function testGenderModel()
//    {
//        $data = self::$holler->gender();
//        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Gender',$data);
//    }
//
//    public function testApplicationModel()
//    {
//        HollerClient::setMasterToken('09016e833e1f78b57de866dddfec4f4d7a337173');
//        $application = self::$holler->application()->find("89225f30f4494dd1302b52d427ab8a98640ff6e3");
//        $applications = self::$holler->application()->all();
//        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Application',$application);
//        $this->assertInstanceOf('Rainmakerlabs\Holler\Support\Collection',$applications);
//    }
//
//
//    public function testCountryModel()
//    {
//        $country = self::$holler->country()->all();
//        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Country',$country);
//    }

}