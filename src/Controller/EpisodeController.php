<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Form\EpisodeType;
use App\Repository\EpisodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/episode')]
class EpisodeController extends AbstractController
{
    #[Route('/', name: 'app_episode_index', methods: ['GET'])]
    public function index(EpisodeRepository $episodeRepository): Response
    {
        return $this->render('episode/index.html.twig', [
            'episodes' => $episodeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_episode_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $episode = new Episode();
        $form = $this->createForm(EpisodeType::class, $episode);
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            $slug = $slugger->slug($episode->getTitle());
            $episode->setSlug($slug);
            $entityManager->persist($episode);
            $entityManager->flush();

            $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to('niko__@live.fr')
            ->subject('Un nouvel episode vient d\'être publié, bon visionnage !')
            ->html($this->renderView('/email/episode/newEpisodeEmail.html.twig', ['episode' => $episode]));

    $mailer->send($email);


            $this->addFlash('success', 'L\'épisode à bien été créer');


            return $this->redirectToRoute('app_episode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('episode/new.html.twig', [
            'episode' => $episode,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_episode_show', methods: ['GET'])]
    public function show(Episode $episode, ProgramDuration $programDuration): Response
    {
        return $this->render('episode/show.html.twig', [
            'episode' => $episode, 'programDuration' => $programDuration->calculateEpisodesTime($program)
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_episode_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Episode $episode, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($episode->getTitle());
            $episode->setSlug($slug);
            $entityManager->flush();

            $this->addFlash('success', 'L\'épisode à bien été modifié');


            return $this->redirectToRoute('app_episode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('episode/edit.html.twig', [
            'episode' => $episode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_episode_delete', methods: ['POST'])]
    public function delete(Request $request, Episode $episode, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$episode->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($episode);
            $entityManager->flush();

            $this->addFlash('danger', 'L\'épisode à été supprimé');
        }

        return $this->redirectToRoute('app_episode_index', [], Response::HTTP_SEE_OTHER);
    }
}
