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
 * Class Gender
 * @package Rainmakerlabs\Holler\Model
 */
class Gender extends BaseModel
{
    protected $primary_key = 'key';

    /**
     * @var array
     */
    protected $attribute_keys = [
        "key",
        "name"
    ];

    /**
     *
     * Get all gender list
     *
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function all()
    {
        $response = HollerClient::_request('GET', 'target', ['content_type' => 'gender']);

        $data = $response->gender;

        return $this->buildCollection($data);
    }

}