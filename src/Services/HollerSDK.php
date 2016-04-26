<?php namespace Rainmakerlabs\Holler\Services;

use Rainmakerlabs\Holler\Model\Application;
use Rainmakerlabs\Holler\Model\Communication;
use Rainmakerlabs\Holler\Model\CommunicationTarget;
use Rainmakerlabs\Holler\Model\CommunicationTargetSegment;
use Rainmakerlabs\Holler\Model\Country;
use Rainmakerlabs\Holler\Model\Designation;
use Rainmakerlabs\Holler\Model\Gender;
use Rainmakerlabs\Holler\Model\Industry;
use Rainmakerlabs\Holler\Model\Interest;
use Rainmakerlabs\Holler\Model\Location;
use Rainmakerlabs\Holler\Model\Subscriber;
use Rainmakerlabs\Holler\Model\SubscriberInfo;
use Rainmakerlabs\Holler\Model\Target;

/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 11/13/15
 * Time: 9:55 AM
 */
class HollerSDK
{

    /**
     * @return Industry
     */
    public function industry()
    {
        return new Industry();
    }

    /**
     * @return Interest
     */
    public function interest()
    {
        return new Interest();
    }

    /**
     * @return Gender
     */
    public function gender()
    {
        return new Gender();
    }

    /**
     * @return Location
     */
    public function location()
    {
        return new Location();
    }

    /**
     * @return Designation
     */
    public function designation()
    {
        return new Designation();
    }

    /**
     * @return Target
     */
    public function target()
    {
        return new Target();
    }

    /**
     * @return Subscriber
     */
    public function subscriber()
    {
        return new Subscriber();
    }

    /**
     * @return SubscriberInfo
     */
    public function subscriberInfo()
    {
        return new SubscriberInfo();
    }

    /**
     * @return Communication
     */
    public function communication()
    {
        return new Communication();
    }

    /**
     * @return Application
     */
    public function application()
    {
        return new Application();
    }

    /**
     * @return Country
     */
    public function country()
    {
        return new Country();
    }

    /**
     * @return CommunicationTarget
     */
    public function communicationTarget()
    {
        return new CommunicationTarget();
    }

    /**
     * @return CommunicationTargetSegment
     */
    public function communicationTargetSegment()
    {
        return new CommunicationTargetSegment();
    }
}