<?php
/**
 * Created by PhpStorm.
 * User: nguyentantam
 * Date: 1/19/16
 * Time: 3:14 PM
 */

namespace Rainmakerlabs\Holler\Tests;

use Rainmakerlabs\Holler\Helper\HollerClient;


class Helper
{
    public static function setUp()
    {
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        date_default_timezone_set('UTC');
        HollerClient::initialize("YOUR-APP-ID", "YOUR-ACCESS-KEY", true, false);

    }

    public static function tearDown()
    {
    }
}