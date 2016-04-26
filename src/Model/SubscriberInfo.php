<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 1/21/16
 * Time: 10:16 AM
 */

namespace Rainmakerlabs\Holler\Model;


/**
 * Class SubscriberInfo
 * @package Rainmakerlabs\Holler\Model
 */
class SubscriberInfo extends BaseModel
{

    /**
     * @var array
     */
    protected $attribute_keys = [
        "gps_latitude",
        "gps_longitude",
        "gender",
        "date_of_birth",
        "country",
        "industry",
        "designation",
        "interest_id",
    ];


    /**
     * @param $value
     * @return $this
     */
    public function setGpsLatitude($value)
    {
        $this->attributes['gps_latitude'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setGpsLongitude($value)
    {
        $this->attributes['gps_longitude'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setGender($value)
    {
        $this->attributes['gender'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDateOfBirth($value)
    {
        $this->attributes['date_of_birth'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setCountry($value)
    {
        $this->attributes['country'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIndustry($value)
    {
        $this->attributes['industry'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDesignation($value)
    {
        $this->attributes['designation'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setInterestId($value)
    {
        $this->attributes['interest_id'] = $value;
        return $this;
    }

}