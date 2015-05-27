<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 27.05.2015
 * Time: 12:04
 * @since 27.05.2015
 * @author Patrick Reimers, Dominik Müller
 * @version 0.1
 */

namespace GIBM13\WetterApi;


/**
 * Class Api
 * @category WheaterAPI
 * @package GIBM13\WetterApi
 */
class Api
{

    const GIBM = 'http://home.gibm.ch/m307/wetter.php';

    const YAHOO = 'http://weather.yahooapis.com/forecast';

    const OPEN_WEATHER = 'http://api.openweathermap.org/data/2.5/forecast/daily';

    /**
     * @var String Api provided in the constructor
     */
    private $api;

    /**
     * @param Api::GIBM|Api::YAHOO|Api::OPEN_WEATHER $api Type of api that you want to use.
     */
    public function __construct($api)
    {
        $this->api = $api;
    }

    public function getWheater($location = null, $date = null)
    {
        $date = !isset($date) ? new \DateTime() : $date;
        
        switch ($this->api){
            case Api::GIBM:
                
                return $this->getWeaterForGibm();
            case Api::YAHOO:
                
                break;
            case Api::OPEN_WEATHER:
                
                break;
            default:
                
                throw new \Exception('Please use one of our provided APIs in the Api class');
        }
    }
    
    private function getWeaterForGibm()
    {
        $response = array();

        if ($fh = fopen($this->api, 'r')){
            while($line = fgets($fh, 1000)){
                $response[] = $line;
            }
            fclose($fh);
            $response = $this->fetchGibmData($response);
        }
        
        return $response;
    }
    
    private function getWeatherForYahoo()
    {
        
    }
    
    private function getWeatherForOpenWeather()
    {
        
    }
    
    private function fetchGibmData($data)
    {
        $response = array();
        foreach($data as $dataset){
            $cells = explode(';', preg_replace('/[\r\n]{1,2}$/', '',$dataset));

            $temperature = explode('/', $cells[3]);
            $wind = explode('/', $cells[4]);

            $location = $this->getLocationForGibmNumber($cells[1]);
            $response[$cells[0]][$location]['weather'] = $cells[2];
            $response[$cells[0]][$location]['temperature'] = array('min' => $temperature[0], 'max' => $temperature[1]);
            $response[$cells[0]][$location]['wind'] =  array('direction' => $wind[0], 'speed' => $wind[1]);
            $response[$cells[0]][$location]['pollen'] = $cells[5];
        }

        return $response;
    }

    /**
     * Resolves number to a defined location.
     *
     * @param Integer $num
     * @return string
     * @throws \Exception
     */
    private function getLocationForGibmNumber($num)
    {
        switch($num){
            case 1:

                return "Zürich";
            case 2:

                return "Genf";
            case 3:

                return "Bern";
            case 4:

                return "Basel";
            case 5:

                return "Graubünden";
            case 6:

                return "Wallis";
            case 7:

                return "Tessin";
            default:

                throw new \Exception("Could not resolve $num to a location.");
        }
    }

}