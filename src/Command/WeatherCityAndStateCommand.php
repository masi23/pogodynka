<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:city-and-state',
    description: 'Add a short description for your command',
)]
class WeatherCityAndStateCommand{
    public function __construct(
        private LocationRepository $locationRepository,
        private WeatherUtil $weatherUtil
    ) {}
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('city name')] string $name,
        #[Argument('state(wojewodztwo)')] string $state,
    ): int {
        $location = $this->locationRepository->findOneBy(['name' => $name, 'state' => $state]);
        $forecast = $this->weatherUtil->getWeatherForLocation($location);
        $io->note(sprintf('Location: %s', $location->getName()));
        $io->table(['Date', 'Temperature'], array_map(fn($m) => [
            $m->getDate()->format('Y-m-d'),
            $m->getTemperature(),
        ], $forecast));
        return Command::SUCCESS;
    }
}
