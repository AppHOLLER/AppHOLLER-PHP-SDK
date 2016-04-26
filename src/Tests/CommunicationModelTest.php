<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 11/16/15
 * Time: 10:44 AM
 */

namespace Rainmakerlabs\Holler\Tests;

use Rainmakerlabs\Holler\Support\Collection;
use PHPUnit_Framework_TestCase;
use Rainmakerlabs\Holler\Services\HollerSDK;


class CommunicationModelTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testGetAllCommunication()
    {
        $data = self::$holler->communication()->all();

        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Communication',$data,false);
    }

    public function testCreateNewCommunicationCampaign()
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

        $communication->setTarget($target);

        $cfile = new \CURLFile('/Users/nguyentantam/Documents/workspace/RML/holler-php-sdk/tea-battery_00293536.jpg','image/jpeg','test_name.jpg');


        $cover_img = $cfile;

//    var_dump($cover_img);
//    die();
        $communication->setCoverImg($cover_img);

        $communication->setTime( date("Y-m-d H:i:s",strtotime("+5 minutes")));
//        $communication->setTime(true);
        $id =$communication->create();

        $this->assertInternalType("int", $id);
    }


    public function testFindCommunicationCampaign()
    {
        $communication = self::$holler->communication();

        $communication = $communication->find(215);

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Communication',$communication);

    }

    public function testUpdateExistCommunicationCampaign()
    {
        //212
        $time_to_send  = date("Y-m-d H:i:s",strtotime("+5 minutes"));
        $communication = self::$holler->communication();
        $communication = $communication->find(214);
        $communication->setName("Name nè edited ". $time_to_send );
//        $communication->setDescription("this is a short description");
//        $communication->setChannel('email',
//            ['subject'=>'subject here '.$time_to_send,'content'=>'asdfasdf','from'=>"nghia.mai@rainmaker-labs.com"]);
////    $communication->setTime(true);
//        $target = self::$holler->communicationTarget();
//
//        $segment = self::$holler->communicationTargetSegment();
//        $segment->setInterest(12);
//
//        $target->setSegment($segment);

//        $communication->setTarget($target);

        $cover_img = new \CURLFile('/Users/nguyentantam/Documents/workspace/RML/holler-php-sdk/tea-battery_00293536.jpg','image/jpeg','test_name');
//
//
//        $cover_img = $cfile;
//
//    var_dump($cover_img);
////    die();
        $communication->setCoverImg($cover_img);
//
//        $communication->setTime( date("Y-m-d H:i:s",strtotime("+5 minutes")));
//        $communication->setTime(true);
        $id =$communication->update();


        $this->assertInternalType("int", $id);
    }

}