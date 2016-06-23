<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 1/26/16
 * Time: 10:35 AM
 */

namespace Rainmakerlabs\Holler\Model;


use Rainmakerlabs\Holler\Helper\HollerClient;
use CURLFile;

/**
 * Class Communication
 * @package Rainmakerlabs\Holler\Model
 */
class Communication extends BaseModel
{
    /**
     * @var array
     */
    protected $attribute_keys = [
        "id",
        "channel",
        "name",
        "description",
        "status",
        "cover_image",
        "all_target",
        "communication_time",
        "updated_at",
        "reached_percentage",
        "segment_target",
        "manual_target",
        "repeated",
        "end_date",
        "subscribers",
        "content",
    ];


    public function setSegmentTargetAttribute($value)
    {
        $this->request_attribute_data['segment_target'] =  new CommunicationTargetSegment((array)$value);
    }


//    /**
//     * @param $object
//     * @return static
//     */
//    protected function buildModel($object)
//    {
//        $model = new static;
//        if($object){
//            foreach ($object as $key => $value) {
//                if (in_array($key, $this->getAttributeKeys())) {
//                    $model->$key = $value;
//                }
//            }
//        }
//        return $model;
//    }


    /**
     * @var
     */
    protected $cover_img;

    /**
     * @return mixed
     */
    public function getCoverImg()
    {
        return $this->cover_img;
    }

    /**
     *
     * Set cover image for communication
     *
     * @param mixed $cover_img
     */
    public function setCoverImg(CURLFile $cover_img)
    {
        $this->cover_img = $cover_img;
    }

    /**
     *
     * Set name for communication campaign
     *
     * @param $value
     * @return $this
     */
    public function setName($value)
    {
        $this->request_attribute_data['name'] = $value;
        return $this;
    }

    /**
     * Set description for communication campaign
     *
     * @param $value
     * @return $this
     */
    public function setDescription($value)
    {
        $this->request_attribute_data['description'] = $value;
        return $this;
    }

    /**
     *
     * Set Channel with type and content:
     * type (string, optional): pushnotif / email / sms = ['pushnotif', 'email', 'sms'],
     * content (object, optional): CONTENT is an object. It's depend on CHANNEL TYPE. If CHANNEL TYPE is 'pushnotif' -> CONTENT is { subject: string, content: string, deep_link: string }. If CHANNEL TYPE is 'email' -> CONTENT is { subject: string, from: string, content: string }. If CHANNEL TYPE is 'sms' -> CONTENT is { from: string, content: string }.
     *
     *
     * @param $type
     * @param $content
     * @return $this
     */
    public function setChannel($type, $content)
    {
        $this->request_attribute_data['channel']['type'] = $type;
        $this->request_attribute_data['channel']['content'] = $content;
        return $this;
    }

    /**
     * Set target for communication campaign
     *
     * @param CommunicationTarget $target
     * @return $this
     */
    public function setTarget(CommunicationTarget $target)
    {
        $this->request_attribute_data['target'] = $target->getAttributes();

        return $this;
    }

    /**
     *
     * Set time to publish communication campaign (boolean or datetime string format)
     *
     * @param boolean|string $value
     * @return $this
     */
    public function setTime($value)
    {
        if ($value === true) {
            $data = [
                'now' => true,
            ];
        } else {
            $data = [
                'now' => false,
            ];
            $datetime = new \DateTime($value);
            $data['date'] = $datetime->format(\DateTime::ISO8601);
        }

        $this->request_attribute_data['time'] = $data;
        return $this;

    }


    /**
     * Get all communication campaign
     *
     * @return \Rainmakerlabs\Holler\Support\Collection
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function all()
    {
        $params = [];
        $response = HollerClient::_request('GET', 'communications', $params);
        return $this->buildCollection($response);
    }


    /**
     * Create a new communication campaign
     *
     * @return integer
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function create()
    {
        $params['data'] = json_encode($this->getRequestAttributeData());
        $params['cover_image'] = $this->getCoverImg();
        $response = HollerClient::_request('POST_WITH_FILE', 'communications/create', $params);

        $this->setAttribute('id', $response->communication_id);
        return $response->communication_id;
    }

    /**
     * @param $id
     * @return static
     * @throws \Exception
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function find($id)
    {
        $response = HollerClient::_request('GET', 'communications/'.$id, []);
        return $this->buildModel($response);
    }

    /**
     * @param null $id
     * @return mixed
     * @throws \Rainmakerlabs\Holler\Exceptions\HollerExceptions
     */
    public function update($id = null)
    {
        if(is_null($id)){
            $id = $this->getAttribute($this->primary_key);
        }

        $data_update = $this->getRequestAttributeData();

        $params['data'] = json_encode($data_update);

        if($cover_img = $this->getCoverImg()){
            $params['cover_image'] = $cover_img;
        }
        $response = HollerClient::_request('PUT_WITH_FILE', 'communications/'.$id, $params);

        return $response->communication_id;
    }

    public function sendPushNotification($params)//$subscribers, $subject, $content, $deeplink = '')
    {
//        $params = array();
//        $params['subscriber_id'] = $subscribers;
//        $params['content'] = array('subject'=>$subject, 'content'=>$content);
//        $params['deeplink'] = $deeplink;

        $response = HollerClient::_request('POST', 'communication/push_notification', $params);
        return $response;
    }
    
    public function sendSMS($params)//$subscribers, $from, $content)
    {
//        $params = array();
//        $params['subscriber_id'] = $subscribers;
//        $params['content'] = array('from'=>$from, 'content'=>$content);

        $response = HollerClient::_request('POST', 'communication/send_sms', $params);
        return $response;
    }
    
    public function sendEmail($params)//$subscribers, $subject, $content)
    {
//        $params = array();
//        $params['subscriber_id'] = $subscribers;
//        $params['content'] = array('subject'=>$subject, 'content'=>$content);

        $response = HollerClient::_request('POST', 'communication/send_email', $params);
        return $response;
    }


}