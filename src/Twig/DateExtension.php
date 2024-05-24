<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DateExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('last_friday_of_month', [$this, 'getLastFridayOfMonth']),
        ];
    }

    public function getLastFridayOfMonth(\DateTime $date): string
    {
        $lastDayOfMonth = $date->format('Y-m-t'); // Get last day of the month
        $lastDayDateTime = new \DateTime($lastDayOfMonth);

        // Find the last Friday of the month
        while ($lastDayDateTime->format('N') != 5) {
            $lastDayDateTime->modify('-1 day');
        }

        // Set the time to 11:00
        $lastDayDateTime->setTime(11, 0);

        return $lastDayDateTime->format('d/m/Y \à H\hi');
    }
}
