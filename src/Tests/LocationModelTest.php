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


class LocationModelTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testGetAllLocation()
    {
        $data = self::$holler->location()->all();

        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Location',$data,false);
    }

    public function testCRULocation()
    {
        $location_model = self::$holler->location();
        $location_model->setGpsLatitude("100.023423423");
        $location_model->setGpsLongitude("10.02342344");
        $location_model->setRadius(10);
        $location_model->setLocationName("Location Name Testing ".date("Y-m-d H:i:s"));
        $location = $location_model->create();

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Location',$location);

        $location_model = self::$holler->location();

        $location = $location_model->find($location->id);
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Location',$location);

        $location->setLocationName("Location Name Testing ".date('Y-m-d H:i:s')." edited");
        $location = $location->update();

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Location',$location);
    }

}