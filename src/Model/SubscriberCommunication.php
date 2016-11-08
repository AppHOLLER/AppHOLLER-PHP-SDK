<?php

    namespace Rainmakerlabs\Holler\Model;


    /**
     * Class SubscriberCommunication
     * @package Rainmakerlabs\Holler\Model
     */
    class SubscriberCommunication extends BaseModel
    {

        protected $attribute_keys = [
            'push',
            'sms',
            'email'
        ];


        /**
         * @param $value
         * @return $this
         */
        public function setPush($value)
        {
            $this->attributes['push'] = $value;
            return $this;
        }

        /**
         * @param $value
         * @return $this
         */
        public function setSms($value)
        {
            $this->attributes['sms'] = $value;
            return $this;
        }

        /**
         * @param $value
         * @return $this
         */
        public function setEmail($value)
        {
            $this->attributes['email'] = $value;
            return $this;
        }
    }