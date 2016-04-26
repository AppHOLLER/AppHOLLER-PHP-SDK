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


class CountryModelTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testCountryModel()
    {
        $country = self::$holler->country()->all();

        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Country',$country);

    }

}