<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 11/16/15
 * Time: 10:44 AM
 */

namespace Rainmakerlabs\Holler\Tests;

use PHPUnit_Framework_TestCase;
use Rainmakerlabs\Holler\Helper\HollerClient;
use Rainmakerlabs\Holler\Services\HollerSDK;


class GenderModelTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testGenderModel()
    {
        $data = self::$holler->gender()->all();
        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Gender',$data);
    }


}