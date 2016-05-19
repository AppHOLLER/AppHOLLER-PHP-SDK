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
 * Class Subscriber
 * @package Rainmakerlabs\Holler\Model
 */
class Subscriber extends BaseModel
{

    /**
     * @var array
     */
    protected $attribute_keys = [
        "id",
        "username",
        "email",
        "first_name",
        "last_name",
        "device_type",
        "device_token",
        "is_active",
        "created_at",
        "phone",
        "updated_at",
        "info",
        "application_id",
    ];


    /**
     * @param $value
     * @return $this
     */
    public function setUsername($value)
    {
        $this->request_attribute_data['username'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEmail($value)
    {
        $this->request_attribute_data['email'] = $value;
        return $this;
    }


    /**
     * @param $value
     * @return $this
     */
    public function setFirstName($value)
    {
        $this->request_attribute_data['first_name'] = $value;
        return $this;
    }


    /**
     * @param $value
     * @return $this
     */
    public function setLastName($value)
    {
        $this->request_attribute_data['last_name'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDeviceType($value)
    {
        $this->request_attribute_data['device_type'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDeviceToken($value)
    {
        $this->request_attribute_data['device_token'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIsActive($value)
    {
        $this->request_attribute_data['is_active'] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPhone($value)
    {
        $this->request_attribute_data['phone'] = $value;
        return $this;
    }

    /**
     * @param SubscriberInfo $value
     * @return $this
     */
    public function setInfo(SubscriberInfo $value)
    {
        $this->request_attribute_data['info'] = $value->getAttributes();
        return $this;
    }

    /**
     * @param $value
     */
    public function setInfoAttribute($value)
    {
        $interest = new SubscriberInfo();
        $this->request_attribute_data['info'] = $interest->buildModel($value);
    }

    /**
     *
     * Register new subscriber
     *
     * @param null $data
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function register($data = null)
    {
        if ($data) {
            $this->syncAttributes($data);
        }
        $data_register = $this->getRequestAttributeData();
        $response = HollerClient::_request('POST', 'subscribers/register', $data_register);
        return $this->buildModel($response);
    }
    /**
     *
     * Register new subscriber
     *
     * @param null $id
     * @param null $data
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function update($id = null,$data = null)
    {

        if(is_null($id)){
            $id = $this->getAttribute($this->primary_key);
        }
        if ($data) {
            $this->syncAttributes($data);
            $this->setRequestAttributeData($data);
        }
        $data_register = $this->getRequestAttributeData();
        $response = HollerClient::_request('PUT', 'subscribers/'.$id, $data_register);
        return $this->buildModel($response);
    }

    /**
     *
     * Login an exist subscriber
     *
     * @param $credentials
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function login($credentials)
    {
        $response = HollerClient::_request('POST', 'subscribers/login', $credentials);
        return $this->buildModel($response);
    }
    /**
     *
     * Get detail subscriber from id
     *
     * @param $id
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function find($id)
    {
        $response = HollerClient::_request('GET', 'subscribers/'.$id, []);
        return $this->buildModel($response);
    }

    /**
     *
     * Get list of subscribers with paging
     *
     * @param int $page
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function paginate($page = 1)
    {
        $params = ['page' => $page];
        $response = HollerClient::_request('GET', 'subscribers', $params);
        return $this->buildPagingCollection($response);
    }

    /**
     *
     * Get list of subscribers without paging
     *
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function all()
    {
        $params = [];
        $response = HollerClient::_request('GET', 'subscribers', $params);
        return $this->buildCollection($response);
    }

    /**
     *
     * Update new location for subscriber
     *
     * @param $latitude
     * @param $longitude
     * @return Subscriber
     */
    public function updateLocation($latitude, $longitude)
    {
        $subscriber_info = new SubscriberInfo();
        $subscriber_info->setGpsLongitude($longitude);
        $subscriber_info->setGpsLatitude($latitude);
        $this->setInfo($subscriber_info);
        $subscriber = $this->update();
        return $subscriber;
    }
}