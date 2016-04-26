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


class SubscriberModelTest extends Holler_PHPUnit_Framework_TestCase
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

    public function testGetAllSubscriber()
    {
        $data = self::$holler->subscriber()->all();

        $this->assertCollectionWithModel('Rainmakerlabs\Holler\Model\Subscriber',$data,false);
    }
    public function testGetPagingSubscriber()
    {
        $data = self::$holler->subscriber()->paginate(1);
        $this->assertPagingCollectionWithModel('Rainmakerlabs\Holler\Model\Subscriber',$data,true);
    }

    public function assertPagingCollectionWithModel($model,Collection $value, $allow_empty_collection = true)
    {
        $this->assertCollectionWithModel($model,$value->get('results'),$allow_empty_collection);
    }


    public function testRegisterSubscriber()
    {
        $subscriber_model = self::$holler->subscriber();
        $subscriber_model->setEmail("test@rainmaker-labs.com");
        $subscriber_model->setUsername("test@rainmaker-labs.com");
        $subscriber_model->setPhone("84 1111111111");
        $subscriber_model->setFirstName("Tam");
        $subscriber_model->setLastName("Nguyen");
        $subscriber_model->setIsActive(true);


        $subscriber_info = self::$holler->subscriberInfo();
        $subscriber_info->setGpsLongitude("100000");
        $subscriber_info->setCountry("SG");
        $subscriber_info->setDateOfBirth("1991-10-10")->setInterestId(11);

        $subscriber_model->setInfo($subscriber_info);
        $subscriber = $subscriber_model->register();

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Subscriber',$subscriber);

    }

    public function testLoginSubscriber()
    {
        $subscriber_model = self::$holler->subscriber();
        $subscriber = $subscriber_model->login(['username'=>'testn@rainmaker-labs.com']);
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Subscriber',$subscriber);
    }

    public function testGetDetailSubscriber()
    {
        $subscriber_model = self::$holler->subscriber();
        $subscriber = $subscriber_model->find(117);
        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Subscriber',$subscriber);
    }

    public function testUpdateSubscriberInfo()
    {
        $subscriber_model = self::$holler->subscriber();
        $subscriber = $subscriber_model->find(117);
//        $subscriber->setFirstName("Tam");

        $subscriber_info = self::$holler->subscriberInfo();
//        $subscriber_info->setGpsLongitude("100000");
//        $subscriber_info->setCountry("SG");
        $subscriber_info->setDateOfBirth("1991-10-12")->setInterestId(11);

        $subscriber->setInfo($subscriber_info);
        $subscriber = $subscriber->update();

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Subscriber',$subscriber);
    }

    public function testUpdateLocationOfSubscriber()
    {
        $subscriber_model = self::$holler->subscriber();
        $subscriber = $subscriber_model->find(117);


        $subscriber = $subscriber->updateLocation("11111","22222");

        $this->assertInstanceOf('Rainmakerlabs\Holler\Model\Subscriber',$subscriber);
    }

}