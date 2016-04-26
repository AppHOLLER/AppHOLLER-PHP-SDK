<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 2/15/16
 * Time: 3:08 PM
 */

namespace Rainmakerlabs\Holler\Tests;


use Rainmakerlabs\Holler\Support\Collection;

class Holler_PHPUnit_Framework_TestCase extends \PHPUnit_Framework_TestCase
{
    public function assertCollectionWithModel($model, $value, $allow_empty_collection = true)
    {
        $result = false;
        if($value instanceof Collection){
            if(!$allow_empty_collection){
                $result = true;
            }elseif($value->first() instanceof $model){
                $result = true;
            }
        }

        $this->assertTrue($result,'Result return should be install of Rainmakerlabs\Holler\Support\Collection and each Item is instance of '.$model);
    }
}