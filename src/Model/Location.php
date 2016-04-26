<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 1/20/16
 * Time: 3:53 PM
 */

namespace Rainmakerlabs\Holler\Model;

use Rainmakerlabs\Holler\Helper\HollerClient;

/**
 * Class Location
 * @package Rainmakerlabs\Holler\Model
 */
class Location extends BaseModel
{
    /**
     * @var array
     */
    protected $attribute_keys = [
        "id",
        "location_name",
        "gps_latitude",
        "gps_longitude",
        "radius",
        "is_published",
    ];


    public function setLocationName($value)
    {
        $this->attributes['location_name'] = $value;
        return $this;
    }

    public function setGpsLatitude($value)
    {
        $this->attributes['gps_latitude'] = $value;
        return $this;
    }

    public function setGpsLongitude($value)
    {
        $this->attributes['gps_longitude'] = $value;
        return $this;
    }

    public function setRadius($value)
    {
        $this->attributes['radius'] = $value;
        return $this;
    }


    /**
     * Get list of locations
     *
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function all()
    {
        $response = HollerClient::_request('GET', 'target', ['content_type' => 'location']);

        $data = $response->location;

        return $this->buildCollection($data);
    }

    /**
     *
     * Create location
     *
     * @param null $data
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function create($data = null)
    {
        if ($data) {
            $this->syncAttributes($data);
        }
        $response = HollerClient::_request('POST', 'location', $this->getAttributes());

        return $this->buildModel($response);

    }

    /**
     *
     * Update location
     *
     * @param null $id
     * @param null $data
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function update($id = null, $data = null)
    {
        if(is_null($id)){
            $id = $this->getAttribute($this->primary_key);
        }
        if ($data) {
            $this->syncAttributes($data);
        }
        $response = HollerClient::_request('PUT', 'location/' . $id, $this->getAttributes());

        return $this->buildModel($response);
    }

    /**
     *
     * Get detail of location from id
     *
     * @param $id
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function find($id)
    {
        $response = HollerClient::_request('GET', 'location/' . $id);
        return $this->buildModel($response);

    }
}