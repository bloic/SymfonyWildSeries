<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/{categoryName}", methods={"GET"}, name="show")
     * @param CategoryRepository $categoryRepository
     * @param ProgramRepository $programRepository
     * @param string $categoryName
     * @return Response
     */
    public function show(CategoryRepository $categoryRepository,ProgramRepository $programRepository, string $categoryName): Response
    {
        $category = $categoryRepository->findBy(['name' => $categoryName]);
        if (!$category) {
            throw $this->createNotFoundException('the category does not exist');
        }
        $programs = $programRepository->findBy(['category'=>$category], ['id' => 'DESC'],3 );
        return $this->render('category/show.html.twig', [
            'categoryName' => $categoryName,
            'programs' =>$programs
        ]);
    }

}
