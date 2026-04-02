<?php

namespace App\Tests\Integration;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductImage;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductDoctrineTest extends KernelTestCase
{
    public function testSomething(): void
{
    self::bootKernel();
    $em = static::getContainer()
        ->get('doctrine')
        ->getManager();

    $category = new Category();
    $category->setNameCategory('Test Cat');

    $produit = new Product();
    $produit->setName("Produit de test");
    $produit->setIsActive(true);  
    $produit->setStock(true);   
    $produit->setDescription("Test description"); 
    $produit->setCategory($category);

    $productImage = new ProductImage();
    $productImage->setImageName('test.jpg');
    $produit->addProductImage($productImage);

    $em->persist($produit);
    $em->flush();

    $this->assertNotNull($produit->getId());
}

public function testLireProduit(): void
{
    self::bootKernel();
    $em = static::getContainer()
        ->get('doctrine')
        ->getManager();

    $repo = $em->getRepository(Product::class); 
    $found = $repo->findOneBy([
        'name' => 'Produit de test'
    ]);
    

    $this->assertNotNull($found);
     $this->assertEquals('Produit de test', $found->getName());
}
}
