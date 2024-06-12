<?php 

namespace App\Controller; 

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; //Cette ligne permet d'afficher la route. 
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

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

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response 
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('program_index');

        }
        return $this->render('program/new.html.twig', ['form' => $form,]); 

    }

    #[Route('/{program}', methods:['GET'], requirements: ['id'=>'\d+'], name: 'show')]
    public function show(Program $program): Response
    {
        // $program = $programRepository->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        return $this->render ('program/show.html.twig', ['program' => $program,]
        );

    }

    #[Route('/{program}/seasons/{season}', name: 'season_show')]
    public function showSeason(Program $program, Season $season): Response
    {
        // $program = $programRepository->findOneBy(['id' => $programId]);
        // $season = $seasonRepository->findOneBy(['id' => $seasonId, 'program' => $program]);
        // $episode = $episodeRepository->findBy(['season' => $season]);

        return $this->render ('program/season_show.html.twig', ['program' => $program, 'season' => $season]
        );

    }
    #[Route('/{program}/seasons/{season}/episode/{episode}', name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {

        return $this->render ('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]
        );

    }

// Function en cours d'écriture. 

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($program);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/trailer', name: 'show_trailer')]
    public function showTrailer(Program $program): Response 
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        return $this->render ('program/show_trailer.html.twig', ['program' => $program]
        );

    }

    #[Route('/{id}/trailer1', name: 'show_trailer1')]
    public function showTrailer1(Program $program): Response 
    {
        
        return $this->render ('program/show_trailer1.html.twig', ['program' => $program]
        );

    }

}

