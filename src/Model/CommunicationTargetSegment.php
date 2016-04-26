<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 1/26/16
 * Time: 1:33 PM
 */

namespace Rainmakerlabs\Holler\Model;


/**
 * Class CommunicationTargetSegment
 * @package Rainmakerlabs\Holler\Model
 */
class CommunicationTargetSegment extends BaseModel
{
    /*
     *  device (string, optional),
     * country (string, optional),
     * gender (string, optional),
     * age (inline_model_1, optional),
     * industry (string, optional),
     * interest (string, optional),
     * designation (string, optional),
     * date_of_register (inline_model_2, optional),
     * location (string, optional)
     */

    protected $attribute_keys = [
        'device',
        'country',
        'gender',
        'age',
        'industry',
        'interest',
        'designation',
        'date_of_register',
        'location',
    ];


    /**
     * @param $value
     * @return $this
     */
    public function setDevice($value)
    {
        $this->attributes['device'] = $value;
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
    public function setGender($value)
    {
        $this->attributes['gender'] = $value;
        return $this;
    }

    /**
     * @param $from
     * @param $to
     * @return $this
     */
    public function setAge($from, $to)
    {
        $this->attributes['age']['from'] = $from;
        $this->attributes['age']['to'] = $to;
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
    public function setInterest($value)
    {
        $this->attributes['interest'] = $value;
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
     * @param $from
     * @param $to
     * @return $this
     */
    public function setDateOfRegister($from, $to)
    {
        $this->attributes['date_of_register']['from'] = $from;
        $this->attributes['date_of_register']['to'] = $to;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLocation($value)
    {
        $this->attributes['location'] = $value;
        return $this;
    }


}