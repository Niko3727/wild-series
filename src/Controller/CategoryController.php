<?php 

namespace App\Controller; 

 
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; //Cette ligne permet d'afficher la route. 
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response 
    {
        $categorys = $categoryRepository->findAll();
        
        return $this->render ('category/index.html.twig', ['categorys' => $categorys]
        );

    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response 
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');

        }
        return $this->render('category/new.html.twig', ['form' => $form,]); 

    }

    #[Route('/{category}', methods:['GET'], requirements: ['id'=>'\d+'], name: 'show')]
    public function show(Category $category): Response
    {
        // $program = $programRepository->findOneBy(['id' => $id]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category with id : '.$id.' found in category\'s table.'
            );
        }

        return $this->render ('category/show.html.twig', ['category' => $category,]
        );

    }


    // #[Route('/{categoryName}', name: 'show')]
    // public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    // {
    //     $category = $categoryRepository->findOneBy(['name' => $categoryName]);

    //     if (!$category) {
    //         throw $this->createNotFoundException(
    //             'Aucune catégorie nommée ' . $categoryName .' est disponible.'
    //         );
    //     }

    //     $programs = $programRepository->findBy(['category' => $category],['id' => 'ASC'], 5);

    //     if (!$programs) {
    //         throw $this->createNotFoundException(
    //             'No category with'.$categoryName.' found in category\'s table.'
    //         );
    //     }

    //     return $this->render ('category/show.html.twig', ['category' => $category, 'programs' => $programs]
    //     );

    // }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
    }
    

}