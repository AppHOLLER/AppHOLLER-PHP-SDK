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


class InterestModelTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testGetAllInterest()
    {
        $data = self::$holler->interest()->all();

        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Interest',$data,false);
    }

    public function testCRUInterest()
    {
        $interest_model = self::$holler->interest();
        $interest_model->setInterestName("Interest Name Testing ".date('Y-m-d H:i:s'));
        $interest_model->setIsPublished(true);
        $interest = $interest_model->create();
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Interest',$interest);

        $interest_model = self::$holler->interest();

        $interest = $interest_model->find($interest->id);
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Interest',$interest);

        $interest->setInterestName("Interest Name Testing ".date('Y-m-d H:i:s')." edited");
        $interest = $interest->update();

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Interest',$interest);
    }

}