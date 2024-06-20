<?php

namespace App\Service;

use App\Entity\Program;

class ProgramDuration
{
    public function calculate(Program $program): array {

        $totalMinutes = 0; 

        foreach ($program->getSeasons() as $season) {
            foreach ($season->getEpisodes() as $episode) {
                $totalMinutes += $episode->getDuration();
            }
            
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


    // }
    // public function calculate(Program $program): string {
    //     $message = 'Coming soon';

    //     return $message;;
    // }

}
