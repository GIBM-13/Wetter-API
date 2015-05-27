<?php
/**
 * Created by PhpStorm.
 * User: Ashura
 * Date: 27.05.15
 * Time: 13:47
 */

use GIBM13\WetterApi\Api;

class ApiTest extends PHPUnit_Framework_TestCase{

    public function testGetWheaterGibm(){
        $api = new Api(Api::GIBM);
        $response = $api->getWheater();
        $this->assertCount(7, $response);
    }
}