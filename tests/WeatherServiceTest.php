<?php
namespace App\Tests\Service;

use App\Service\WeatherService;
use PHPUnit\Framework\TestCase;

class WeatherServiceTest extends TestCase
{
    // Assert function to test connection with Api Key
    // and check if service return an array of 13 keys (by default openweather)
    public function testGetWeather()
    {
        $weather = new WeatherService($apiKey = $_ENV['WEATHER_API_KEY']);
        $result = $weather->getWeather();

        $this->assertEquals(13, count($result), "array length doesn't match");
    }
}

?>