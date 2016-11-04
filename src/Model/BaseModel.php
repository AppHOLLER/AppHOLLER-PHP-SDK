<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 1/20/16
 * Time: 11:18 AM
 */

namespace Rainmakerlabs\Holler\Model;

use Rainmakerlabs\Holler\Support\Collection;
use Rainmakerlabs\Holler\Support\Str;

/**
 * Class BaseModel
 * @package Rainmakerlabs\Holler\Model
 */
class BaseModel
{

    /**
     * @var array
     */
    protected $attributes = [];
    /**
     * @var array
     */
    protected $attribute_keys = [];

    /**
     * @var string
     */
    protected $primary_key = "id";

    /**
     * @return array
     */
    public function getRequestAttributeData()
    {
        return $this->request_attribute_data;
    }

    /**
     * @param array $request_attribute_data
     */
    public function setRequestAttributeData($request_attribute_data)
    {
        $this->request_attribute_data = $request_attribute_data;
    }

    /**
     * @param array | null $attributes
     */
    public function __construct($attributes = null)
    {
        if (!is_null($attributes)) {
            $this->syncAttributes($attributes);
        }
    }

    /**
     * @var array
     */
    protected $request_attribute_data = [];


    /**
     *
     * return primary key of model
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->{$this->primary_key};
    }


    /**
     * @return array
     */
    public function getAttributeKeys()
    {
        return $this->attribute_keys;
    }


    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $attributes
     * @return $this
     */
    public function syncAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->attributes) || $this->hasGetMutator($key)) {
            return $this->getAttributeValue($key);
        }
        return null;
    }


    /**
     * Get a plain attribute (not a relationship).
     *
     * @param  string $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        $value = $this->getAttributeFromArray($key);

        // If the attribute has a get mutator, we will call that then return what
        // it returns as the value, which is useful for transforming values on
        // retrieval from the model to a form that is more useful for usage.
        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key, $value);
        }

        // If the attribute exists within the cast array, we will convert it to
        // an appropriate native PHP type dependant upon the associated value
        // given with the key in the pair. Dayle made this comment line up.
//        if ($this->hasCast($key)) {
//            $value = $this->castAttribute($key, $value);
//        }

        // If the attribute is listed as a date, we will convert it to a DateTime
        // instance on retrieval, which makes it quite convenient to work with
        // date fields without having to create a mutator for each property.
//        elseif (in_array($key, $this->getDates())) {
//            if (! is_null($value)) {
//                return $this->asDateTime($value);
//            }
//        }

        return $value;
    }


    /**
     * Get an attribute from the $attributes array.
     *
     * @param  string $key
     * @return mixed
     */
    protected function getAttributeFromArray($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        return null;
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string $key
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set' . Str::studly($key) . 'Attribute');
    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string $key
     * @return bool
     */
    public function hasGetMutator($key)
    {
        return method_exists($this, 'get' . Str::studly($key) . 'Attribute');
    }


    /**
     * Get the value of an attribute using its mutator.
     *
     * @param  string $key
     * @param  mixed $value
     * @return mixed
     */
    protected function mutateAttribute($key, $value)
    {
        return $this->{'get' . Str::studly($key) . 'Attribute'}($value);
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }


    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            $method = 'set' . Str::studly($key) . 'Attribute';

            return $this->{$method}($value);
        }

//        // If an attribute is listed as a "date", we'll convert it from a DateTime
//        // instance into a form proper for storage on the database tables using
//        // the connection grammar's date format. We will auto set the values.
//        elseif ($value && (in_array($key, $this->getDates()) || $this->isDateCastable($key))) {
//            $value = $this->fromDateTime($value);
//        }
//
//        if ($this->isJsonCastable($key) && ! is_null($value)) {
//            $value = $this->asJson($value);
//        }

        $this->attributes[$key] = $value;

        return $this;
    }


    /**
     * Checking a given attribute on the model.
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->getAttribute($key));
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }


    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
        } else {
            return json_encode(get_object_vars($this));
        }
    }


    /**
     * @param $object
     * @return static
     */
    protected function buildModel($object)
    {
        $model = new static;
        if($object){
            foreach ($object as $key => $value) {
                if (in_array($key, $this->getAttributeKeys())) {
                    $model->setAttribute($key,$value);
                }
            }
        }
        return $model;
    }

    /**
     * @param $lists
     * @return Collection
     */
    protected function buildCollection($lists)
    {
        $collection = new Collection();
        foreach ($lists as $object) {
            $collection->push($this->buildModel($object));
        }
        return $collection;
    }

    /**
     * @param $lists
     * @return Collection
     */
    protected function buildPagingCollection($lists)
    {
        $results = new Collection();

        if (isset($lists->results)) {
            foreach ($lists->results as $object) {
                $results->push($this->buildModel($object));
            }
        }

        $collection = new Collection();

        $collection->put('count', $lists->count);
        if(isset($lists->next)){
            $collection->put('next', $lists->next);
        }
        if(isset($lists->previous)){
            $collection->put('previous', $lists->previous);
        }
        $collection->put('results', $results);

        return $collection;
    }


}