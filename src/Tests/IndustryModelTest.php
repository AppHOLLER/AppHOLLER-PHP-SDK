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


class IndustryModelTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testGetAllIndustry()
    {
        $data = self::$holler->industry()->all();

        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Industry',$data,false);
    }

    public function testCRUIndustry()
    {
        $industry_model = self::$holler->industry();
        $industry_model->setIndustryName("Industry Name Testing ".date('Y-m-d H:i:s'));
        $industry_model->setIsPublished(true);
        $industry = $industry_model->create();
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Industry',$industry);

        $industry_model = self::$holler->industry();

        $industry = $industry_model->find($industry->id);
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Industry',$industry);

        $industry->setIndustryName("Industry Name Testing ".date('Y-m-d H:i:s')." edited");
        $industry = $industry->update();

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Industry',$industry);
    }

}