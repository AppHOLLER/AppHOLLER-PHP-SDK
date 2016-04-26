<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 1/20/16
 * Time: 11:41 AM
 */

namespace Rainmakerlabs\Holler\Model;

use Rainmakerlabs\Holler\Support\Collection;
use Rainmakerlabs\Holler\Helper\HollerClient;


/**
 * Class Application
 * @package Rainmakerlabs\Holler\Model
 */
class Application extends BaseModel
{

    /**
     * @var array
     */
    protected $attribute_keys = [
        "id",
        "name",
        "application_id",
        "access_key_api",
        "description",
        "apns_p12",
        "apns_env",
        "gcm_apikey",
        "created_at",
        "updated_at",
        "timezone",
        "logo_img",
        "is_demo"
    ];


    /**
     *
     * Get list of applications
     *
     * @return Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function all()
    {
        $response = HollerClient::_request('GET', 'apps', []);
        return $this->buildCollection($response);
    }

    /**
     *
     * Find application detail by application's id
     *
     * @param $id
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function find($id)
    {
        $response = HollerClient::_request('GET', 'apps/' . $id, []);
        return $this->buildModel($response);

    }


}