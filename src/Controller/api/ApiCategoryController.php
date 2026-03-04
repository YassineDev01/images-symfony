<?php

namespace App\Controller\api;

use App\Repository\CategoryRepository;
use App\Mapping\CategoryMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/categories')]
class ApiCategoryController extends AbstractController
{
    #[Route('', name: 'api_categories_index', methods: ['GET'])]
    public function index(
        CategoryRepository $categoryRepository,
        CategoryMapping $mapper
    ): JsonResponse {
        $categories = $categoryRepository->findAll();

        $data = [];

        foreach ($categories as $category) {
            $data[] = $mapper->mapCategoryToDTO($category);
        }

        return $this->json($data);
    }

    #[Route('/{id}', name: 'categories', methods: ['GET'])]
    public function show(
        int $id,
        CategoryRepository $categoryRepository,
        CategoryMapping $mapper
    ): JsonResponse {
        $category = $categoryRepository->find($id);

        if (!$category) {
            return $this->json(['error' => 'Category not found'], 404);
        }

        $data = $mapper->mapCategoryToDTO($category);

        return $this->json($data);
    }
}
