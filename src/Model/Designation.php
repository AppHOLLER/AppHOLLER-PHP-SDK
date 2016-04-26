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
 * Class Designation
 * @package Rainmakerlabs\Holler\Model
 */
class Designation extends BaseModel
{
    /**
     * @var array
     */
    protected $attribute_keys = [
        "id",
        "designation_name",
        "is_published"
    ];

    public function setDesignationName($value)
    {
        $this->attributes['designation_name'] = $value;
        return $this;
    }

    public function setIsPublished($value)
    {
        $this->attributes['is_published'] = $value;
        return $this;
    }

    /**
     * Get all designations
     *
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function all()
    {
        $response = HollerClient::_request('GET', 'target', ['content_type' => 'designation']);

        $data = $response->designation;

        return $this->buildCollection($data);
    }

    /**
     * Create new designation for application
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
        $response = HollerClient::_request('POST', 'designation', $this->getAttributes());

        return $this->buildModel($response);

    }

    /**
     *
     * Update designation
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
        $response = HollerClient::_request('PUT', 'designation/' . $id, $this->getAttributes());

        return $this->buildModel($response);
    }

    /**
     * Get detail of designation from id
     *
     * @param $id
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function find($id)
    {
        $response = HollerClient::_request('GET', 'designation/' . $id);
        return $this->buildModel($response);

    }
}