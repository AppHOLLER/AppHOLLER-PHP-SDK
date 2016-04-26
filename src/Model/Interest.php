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
 * Class Interest
 * @package Rainmakerlabs\Holler\Model
 */
class Interest extends BaseModel
{
    /**
     * @var array
     */
    protected $attribute_keys = [
        "id",
        "interest_name",
        "is_published"
    ];

    /**
     * @param $value
     * @return $this
     */
    public function setInterestName($value)
    {
        $this->attributes['interest_name'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIsPublished($value)
    {
        $this->attributes['is_published'] = $value;
        return $this;
    }

    /**
     *
     * Get all interest items
     *
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function all()
    {
        $response = HollerClient::_request('GET', 'target', ['content_type' => 'interest']);

        $data = $response->interest;

        return $this->buildCollection($data);
    }

    /**
     *
     * Create interest
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
        $response = HollerClient::_request('POST', 'interest', $this->getAttributes());

        return $this->buildModel($response);

    }

    /**
     *
     * Update Interest
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
        $response = HollerClient::_request('PUT', 'interest/' . $id, $this->getAttributes());

        return $this->buildModel($response);
    }

    /**
     *
     * Get detail of interest
     *
     * @param $id
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function find($id)
    {
        $response = HollerClient::_request('GET', 'interest/' . $id);
        return $this->buildModel($response);

    }
}