<?php

namespace App\Tests\Integration;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductDoctrineTest extends KernelTestCase
{
    public function testSomething(): void
{
    self::bootKernel();
    $em = static::getContainer()->get('doctrine')->getManager();

    // ✅ Catégorie
    $category = new Category();
    $category->setNameCategory('Test Cat');
    $em->persist($category);

    // ✅ Produit
    $produit = new Product();
    $produit->setName("Produit de test");
    $produit->setIsActive(true);  
    $produit->setStock(true);    
    $produit->setCategory($category);

    $em->persist($produit);
    $em->flush();

    $this->assertNotNull($produit->getId());
}
}
