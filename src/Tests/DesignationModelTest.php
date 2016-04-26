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


class DesignationModelTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testGetAllDesignation()
    {
        $data = self::$holler->designation()->all();

        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Designation',$data,false);
    }

    public function testCRUDesignation()
    {
        $designation_model = self::$holler->designation();
        $designation_model->setDesignationName("Designation Name Testing ".date('Y-m-d H:i:s'));
        $designation_model->setIsPublished(true);
        $designation = $designation_model->create();
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Designation',$designation);

        $designation_model = self::$holler->designation();

        $designation = $designation_model->find($designation->id);
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Designation',$designation);

        $designation->setDesignationName("Designation Name Testing ".date('Y-m-d H:i:s')." edited");
        $designation = $designation->update();

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Designation',$designation);
    }

}