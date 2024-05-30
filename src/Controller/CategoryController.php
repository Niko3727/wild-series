<?php 

namespace App\Controller; 

 
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; //Cette ligne permet d'afficher la route. 
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response 
    {
        $categorys = $categoryRepository->findAll();
        
        return $this->render ('category/index.html.twig', ['categorys' => $categorys]
        );

    }
    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'Aucune catégorie nommée ' . $categoryName .' est disponible.'
            );
        }

        $programs = $programRepository->findBy(['category' => $category],['id' => 'ASC'], 5);

        if (!$programs) {
            throw $this->createNotFoundException(
                'No category with'.$categoryName.' found in category\'s table.'
            );
        }

        return $this->render ('category/show.html.twig', ['category' => $category, 'programs' => $programs]
        );

    }
}