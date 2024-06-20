<?php 

namespace App\Controller; 

use App\Entity\Actor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ActorRepository;
use App\Form\ActorType;
use Symfony\Component\String\Slugger\SluggerInterface;
 //Cette ligne permet d'afficher la route. 

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ActorRepository $actorRepository): Response 
    {
  
        $actors = $actorRepository->findAll();
        
        return $this->render ('actor/index.html.twig', ['actors' => $actors]
        );

    }
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $slug = $slugger->slug($actor->getName());
        $program->setSlug($slug);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actor);
            $entityManager->flush();

            $this->addFlash('success', 'L\'acteur à bien été créer');


            return $this->redirectToRoute('actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actor/new.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }




    #[Route('/{slug}', methods:['GET'], requirements: ['id'=>'\d+'], name: 'show')]
    public function show(Actor $actor): Response
    {
    
        return $this->render ('actor/show.html.twig', ['actor' => $actor,]
        );

    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actor $actor, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($actor->getName());
            $program->setSlug($slug);
            $entityManager->flush();

            $this->addFlash('success', 'L\'acteur à bien été modifié');


            return $this->redirectToRoute('actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Actor $actor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actor->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($actor);
            $entityManager->flush();

            $this->addFlash('danger', 'L\'acteur à été supprimé');
        }

        return $this->redirectToRoute('actor_index', [], Response::HTTP_SEE_OTHER);
    }

    }


