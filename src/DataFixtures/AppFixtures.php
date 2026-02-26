<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setDescription('Description for product ' . $i);
            $product->setIsActive(true);
            $product->setStock(true);

            $manager->persist($product);
        }

        $category1 = new Category();
        $category1->setNameCategory('Electronics');
        $category1->setDescriptionCategory('Electronic products');
        $category1->setImageName('image2.png');
        $category1->setUpdatedAt(new \DateTimeImmutable());

        $manager->persist($category1);

        $category2 = new Category();
        $category2->setNameCategory('Clothes');
        $category2->setDescriptionCategory('Fashion products');
        $category2->setImageName('image3.png');

        $manager->persist($category2);
      

        $manager->flush();
    }
}
