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
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use App\Service\ProgramDuration;
use App\Service\SeasonDuration;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index( ProgramRepository $programRepository, ProgramDuration $programDuration): Response 
    {
        $programs = $programRepository->findAll();

        $times = [];
        foreach($programs as $program) {
            $times[$program->getId()] = $programDuration ->calculate($program);
        }
        
        return $this->render ('program/index.html.twig', ['programs' => $programs, 'programDuration' => $programDuration, 'times' => $times]
        );
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response 
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {    
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);

            $entityManager->persist($program);
            $entityManager->flush();

            $email = (new Email())
                    ->from($this->getParameter('mailer_from'))
                    ->to('niko__@live.fr')
                    ->subject('Une nouvelle série vient d\'être publié, bon visionnage !')
                    ->html($this->renderView('/email/program/newProgramEmail.html.twig', ['program' => $program]));

            $mailer->send($email);



            $this->addFlash('success', 'Le program à bien été créer');

            return $this->redirectToRoute('program_index');

        }
        return $this->render('program/new.html.twig', ['form' => $form,]); 

    }

    #[Route('/{slug}', methods:['GET'], name: 'show')]
    public function show(Program $program, ProgramDuration $programDuration, SluggerInterface $slugger, ): Response
    {
        // $program = $programRepository->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        return $this->render ('program/show.html.twig', ['program' => $program, 'programDuration' => $programDuration->calculate($program)
        ]
        );

    }

    #[Route('/{slug}/seasons/{number}', name: 'season_show')]
    public function showSeason(Program $program, Season $season, SeasonDuration $seasonDuration): Response
    {
        // $program = $programRepository->findOneBy(['id' => $programId]);
        // $season = $seasonRepository->findOneBy(['id' => $seasonId, 'program' => $program]);
        // $episode = $episodeRepository->findBy(['season' => $season]);

        return $this->render ('program/season_show.html.twig', ['program' => $program, 'season' => $season, 'seasonDuration' => $seasonDuration->calculateSeasonTime($season)]
        );

    }
    #[Route('/{program_slug}/seasons/{number}/episode/{episode_slug}', name: 'episode_show')]
    public function showEpisode(
        #[MapEntity(mapping: ['program_slug' => 'slug'])] Program $program, 
        Season $season, 
        #[MapEntity(mapping: ['episode_slug' => 'slug'])] Episode $episode,
        SluggerInterface $slugger
        ): Response {
    



        return $this->render ('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]
        );

    }

// Function en cours d'écriture. 

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $entityManager->flush();

            
        $this->addFlash('success', 'Le program à bien été bien modifié');

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

            $this->addFlash('danger', 'Le program à été supprimé');

            
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
