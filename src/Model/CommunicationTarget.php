<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 1/26/16
 * Time: 11:14 AM
 */

namespace Rainmakerlabs\Holler\Model;


/**
 * Class CommunicationTarget
 * @package Rainmakerlabs\Holler\Model
 */
class CommunicationTarget extends BaseModel
{
    /**
     * @var array
     */
    protected $attribute_keys = [
        'segment',
    ];

    /**
     * Set segment for communication target
     *
     * Segment {
     * device (string, optional),
     * country (string, optional),
     * gender (string, optional),
     * age (inline_model_1, optional),
     * industry (string, optional),
     * interest (string, optional),
     * designation (string, optional),
     * date_of_register (inline_model_2, optional),
     * location (string, optional)
     * }
     *
     * @param CommunicationTargetSegment $data
     * @return $this
     */
    public function setSegment(CommunicationTargetSegment $data)
    {
        $this->attributes['segment'] = $data->getAttributes();
        return $this;
    }
}