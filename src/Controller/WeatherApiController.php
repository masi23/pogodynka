<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherApiController extends AbstractController
{
    public function __construct(private WeatherUtil $weatherUtil) {

    }

    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        #[MapQueryParameter] string $name,
        #[MapQueryParameter] string $state,
        #[MapQueryParameter] string $format,
        #[MapQueryParameter('twig')] bool $twig = false
    )
    {
        $forecast = $this->weatherUtil->getWeatherForStateAndCity($state, $name);

        $measurements = array_map(fn($f) => [
            'date' => $f->getDate()->format('Y-m-d'),
            'temperature' => $f->getTemperature(),
            'fahrenheit' => $f->getFahrenheit(),
            'rain_mm' => $f->getRainMm(),
            'pressure' => $f->getPressure(),
        ], $forecast);

        $data = [
            'name' => $name,
            'state' => $state,
            'measurements' => $measurements,
        ];

        if($format == 'json') {
            if($twig) {
                return $this->render(
                    'weather_api/index.json.twig',
                    [
                        'name' => $name,
                        'state' => $state,
                        'measurements' => $measurements
                    ],
                    new Response(headers: [
                        'Content-Type' => 'text/html; charset=UTF-8',
                    ])
                );
            }
            return $this->json($data);
        } elseif ($format === 'csv') {
            if ($twig) {
                return $this->render(
                    'weather_api/index.csv.twig',
                    [
                        'name' => $name,
                        'state' => $state,
                        'measurements' => $measurements
                    ],
                    new Response(headers: [
                        'Content-Type' => 'text/html; charset=UTF-8',
                    ])
                );
            }

            $rows = [];
            $rows[] = implode(',', [
                'name',
                'state',
                'date',
                'temperature',
                'fahrenheit',
                'rain_mm',
                'pressure'
            ]);

            foreach ($measurements as $measurement) {
                $rows[] = sprintf(
                    '%s,%s,%s,%s,%s,%s,%s',
                    $name,
                    $state,
                    $measurement['date'],
                    $measurement['temperature'],
                    $measurement['fahrenheit'],
                    $measurement['rain_mm'],
                    $measurement['pressure']
                );
            }

            return new Response(
                implode("\n", $rows),
                Response::HTTP_OK,
                ['Content-Type' => 'text/plain; charset=UTF-8']
            );
        }

        return new Response(
            'Unsupported format',
            Response::HTTP_BAD_REQUEST
        );
    }
}
