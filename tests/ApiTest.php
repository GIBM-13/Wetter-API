<?php
/**
 * Created by PhpStorm.
 * User: Ashura
 * Date: 27.05.15
 * Time: 13:47
 */

use GIBM13\WetterApi\Api;

class ApiTest extends PHPUnit_Framework_TestCase{

    public function testGetWeatherGibm(){
        $api = new Api(Api::GIBM);
        $response = $api->getWeather();
        $this->assertCount(7, $response);
    }

    public function testGetWeatherYahoo(){
        $api = new Api(Api::YAHOO);
        $response = $api->getWeather();
        $this->assertNull($response);
    }

    public function testGetWeatherOpenWeather(){
        $api = new Api(Api::OPEN_WEATHER);
        $response = $api->getWeather();
        $this->assertNull($response);
    }

    /**
     * @expectedException \Exception
     * @throws Exception
     */
    public function testGetLocationForGibmNumberException(){
        $api = new Api(Api::GIBM);
        $api->getLocationForGibmNumber(0);
    }

    /**
     * @expectedException \Exception
     * @throws Exception
     */
    public function testGetWeatherException(){
        $api = new Api(null);
        $api->getWeather();
    }
}