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


class TargetModelTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testGetAllTarget()
    {
        $get_all_target = self::$holler->target()->get();
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Target',$get_all_target);
    }
    public function testGetActiveTarget()
    {
        $data = self::$holler->target()->getActive();
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Target',$data);
    }
    public function testGetInterestTarget()
    {
        $data = self::$holler->target()->get('interest');
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Target',$data);
        $this->assertNotEmpty($data->interest);
        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Interest',$data->interest);
//        $this->assertNotEmpty($data->country);
    }


}