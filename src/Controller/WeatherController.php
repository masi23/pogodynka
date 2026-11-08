<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForecastRepository;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{name}', name: 'app_weather')]
    public function city(Location $location, WeatherUtil $util, ForecastRepository $repository): Response
    {
//        $forecast = $repository->findByLocation($location);
        $forecast = $util->getWeatherForLocation($location);
//        dd($forecast);
        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecast' => $forecast,
        ]);
    }
}
