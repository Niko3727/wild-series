<?php 

namespace App\Controller; 

use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; //Cette ligne permet d'afficher la route. 
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response 
    {
        $programs = $programRepository->findAll();
        
        return $this->render ('program/index.html.twig', ['programs' => $programs]
        );

    }

    #[Route('/{id}', methods:['GET'], requirements: ['id'=>'\d+'], name: 'show')]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        return $this->render ('program/show.html.twig', ['program' => $program,]
        );

    }

    #[Route('/{programId}/seasons/{seasonId}', name: 'season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository ): Response
    {
        $program = $programRepository->findOneBy(['id' => $programId]);
        $season = $seasonRepository->findOneBy(['id' => $seasonId, 'program' => $program]);
        $episodes = $episodeRepository->findBy(['season' => $season]);

        return $this->render ('program/season_show.html.twig', ['program' => $program, 'season' => $season, 'episodes' => $episodes]
        );

    }
}