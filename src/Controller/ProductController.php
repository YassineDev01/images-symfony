<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\ProductImage;


#[Route('/product')]
final class ProductController extends AbstractController
{
    #[Route(name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAllOrdered(),
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
    
            // 👇 Récupérer les images
            $images = $form->get('imagesFiles')->getData();
    
            if ($images) {
                foreach ($images as $imageFile) {
    
                    $productImage = new ProductImage();
                    $productImage->setImageFile($imageFile);
                    $productImage->setProduct($product);
    
                    $entityManager->persist($productImage);
                }
            }
    
            $entityManager->persist($product);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_product_index');
        }
    
        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(), // ⚠️ important
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

  #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(ProductType::class, $product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        // 👇 Gérer les nouvelles images
        $images = $form->get('imagesFiles')->getData();

        if ($images) {
            foreach ($images as $imageFile) {

                $productImage = new ProductImage();
                $productImage->setImageFile($imageFile);
                $productImage->setProduct($product);

                $entityManager->persist($productImage);
            }
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_product_index');
    }

    return $this->render('product/edit.html.twig', [
        'product' => $product,
        'form' => $form->createView(), // ⚠️ important
    ]);
}

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

    // La rout pour supprimer d'une image d'un produit
    #[Route('/image/{id}/delete', name: 'product_image_delete')]
public function deleteImage(ProductImage $image, EntityManagerInterface $em): Response
{
    $productId = $image->getProduct()->getId();

    $em->remove($image);
    $em->flush();

    return $this->redirectToRoute('app_product_edit', [
        'id' => $productId
    ]);
}
}
