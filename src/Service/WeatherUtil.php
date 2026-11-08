<?php

declare(strict_types=1);



namespace App\Service;



use App\Entity\Location;

use App\Entity\Forecast;
use App\Repository\ForecastRepository;
use App\Repository\LocationRepository;


class WeatherUtil

{
    public function __construct(
        private  ForecastRepository $forecastRepository,
        private LocationRepository $locationRepository
    ) {}

    /**

     * @return Forecast[]

     */

    public function getWeatherForLocation(Location $location): array

    {
        return $this->forecastRepository->findByLocation($location);

    }



    /**

     * @return Forecast[]

     */

    public function getWeatherForCountryAndCity(string $state, string $name): array

    {
        $location = $this->locationRepository->findOneBy([
            'name' => $name,
            'state' => $state
        ]);
        if($location == null) return [];
        return $this->forecastRepository->findByLocation($location);
    }

}
