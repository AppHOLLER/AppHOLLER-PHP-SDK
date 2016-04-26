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
 * Class Industry
 * @package Rainmakerlabs\Holler\Model
 */
class Industry extends BaseModel
{
    /**
     * @var array
     */
    protected $attribute_keys = [
        "id",
        "industry_name",
        "is_published"
    ];

    public function setIndustryName($value)
    {
        $this->attributes['industry_name'] = $value;
        return $this;
    }

    public function setIsPublished($value)
    {
        $this->attributes['is_published'] = $value;
        return $this;
    }

    /**
     * Get all industry list
     *
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function all()
    {
        $response = HollerClient::_request('GET', 'target', ['content_type' => 'industry']);

        $data = $response->industry;

        return $this->buildCollection($data);
    }

    /**
     * Create industry
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
        $response = HollerClient::_request('POST', 'industry', $this->getAttributes());

        return $this->buildModel($response);

    }

    /**
     *
     * Update an industry
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
        $response = HollerClient::_request('PUT', 'industry/' . $id, $this->getAttributes());

        return $this->buildModel($response);
    }

    /**
     * Get detail of industry from id
     *
     * @param $id
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function find($id)
    {
        $response = HollerClient::_request('GET', 'industry/' . $id);
        return $this->buildModel($response);

    }
}