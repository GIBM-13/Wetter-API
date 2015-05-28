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
        $this->assertCount(7, $response[date('Y-m-d')]);
        $this->assertCount(4, $response[date('Y-m-d')]['Basel']);
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

    public function testGetLocationForGibmNumber(){
        $api = new Api(Api::GIBM);
        $this->assertEquals("Zürich", $api->getLocationForGibmNumber(1));
        $this->assertEquals("Genf", $api->getLocationForGibmNumber(2));
        $this->assertEquals("Bern", $api->getLocationForGibmNumber(3));
        $this->assertEquals("Basel", $api->getLocationForGibmNumber(4));
        $this->assertEquals("Graubünden", $api->getLocationForGibmNumber(5));
        $this->assertEquals("Wallis", $api->getLocationForGibmNumber(6));
        $this->assertEquals("Tessin", $api->getLocationForGibmNumber(7));
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