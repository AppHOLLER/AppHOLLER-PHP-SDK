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
        HollerClient::initialize("d2798c58f6fa2bae5c53a177722d93b43b7fde2a", "ee7c9604ff33de158d0e5f848d208d96f2eb4243", true, false);

    }

    public static function tearDown()
    {
    }
}