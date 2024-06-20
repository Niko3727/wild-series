<?php

namespace App\Service;

use App\Entity\season;

class SeasonDuration
{
     public function calculateSeasonTime(Season $season): array {

        $totalMinutes = 0; 

        foreach ($season->getEpisodes() as $episode) {
                $totalMinutes += $episode->getDuration();
            }
            
        return $this->convertMinutesToDaysHoursMinutes($totalMinutes);
    } 

    private function convertMinutesToDaysHoursMinutes(int $totalMinutes): array 
    {
        $days = round($totalMinutes / 1440);
        $hours = round(($totalMinutes % 1440) / 60);
        $minutes = $totalMinutes % 60; 

        return [
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
        ];

    }

   

}