<?php

namespace App\Controller\api;

use App\Repository\ProductRepository;
use App\Mapping\ProductMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/products')]
class ProductController extends AbstractController
{
   #[Route('', name: 'api_products_index', methods: ['GET'])]
public function index(
    ProductRepository $productRepository,
    ProductMapping $mapper
): JsonResponse {

    $products = $productRepository->findAllWithImages();

    $data = [];

    foreach ($products as $product) {
        $data[] = $mapper->mapProductToDTO($product);
    }

    return $this->json($data);
}

#[Route('/{id}', name: 'products', methods: ['GET'])]
public function show(
    int $id,
    ProductRepository $productRepository,
    ProductMapping $mapper
): JsonResponse {
    $product = $productRepository->find($id);

    if (!$product) {
        return $this->json(['error' => 'Product not found'], 404);
    }

    $data = $mapper->mapProductToDTO($product);

    return $this->json($data);

}
}