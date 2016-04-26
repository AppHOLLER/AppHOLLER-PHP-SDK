<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 1/21/16
 * Time: 10:16 AM
 */

namespace Rainmakerlabs\Holler\Model;

use Rainmakerlabs\Holler\Helper\HollerClient;

/**
 * Class Target
 * @package Rainmakerlabs\Holler\Model
 */
class Target extends BaseModel
{

    /**
     * @var array
     */
    protected $attribute_keys = [
        "country",
        "designation",
        "interest",
        "industry",
        "location",
        "gender",
    ];

    /**
     *
     * Get list target
     *
     * @param string|null $content_type
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function get($content_type = null)
    {
        if (is_null($content_type)) {
            $content_type = 'country,designation,interest,industry,location,gender';
//            $content_type = 'interest,industry,gender';
        }
        $response = HollerClient::_request('GET', 'target', ['content_type' => $content_type]);

        return $this->buildModel($response);
    }
    /**
     *
     * Get list active target
     *
     * @param string|null $content_type
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function getActive($content_type = null)
    {
        if (is_null($content_type)) {
            $content_type = 'country,designation,interest,industry,location,gender';
//            $content_type = 'interest,industry,gender';
        }
        $response = HollerClient::_request('GET', 'target', ['content_type' => $content_type,
            'is_published_interest'=>1,
            'is_published_industry'=>1,
            'is_published_designation'=>1
        ]);

        return $this->buildModel($response);
    }

    /**
     * @param $value
     */
    public function setInterestAttribute($value)
    {
        $interest = new Interest();
        $this->attributes['interest'] = $interest->buildCollection($value);
    }

    /**
     * @param $value
     */
    public function setDesignationAttribute($value)
    {
        $interest = new Designation();
        $this->attributes['designation'] = $interest->buildCollection($value);
    }

    /**
     * @param $value
     */
    public function setCountryAttribute($value)
    {
        $interest = new Country();
        $this->attributes['country'] = $interest->buildCollection($value);
    }

    /**
     * @param $value
     */
    public function setIndustryAttribute($value)
    {
        $interest = new Industry();
        $this->attributes['industry'] = $interest->buildCollection($value);
    }

    /**
     * @param $value
     */
    public function setGenderAttribute($value)
    {
        $interest = new Gender();
        $this->attributes['gender'] = $interest->buildCollection($value);
    }

    /**
     * @param $value
     */
    public function setLocationAttribute($value)
    {
        $interest = new Location();
        $this->attributes['location'] = $interest->buildCollection($value);
    }


}