<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // ========================
        // 👑 Création Admin
        // ========================

        $admin = new User();
        $admin->setEmail('admin@test.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNom('testnom');
        $admin->setPrenom('testpreno');

        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            '123'
        );

        $admin->setPassword($hashedPassword);

        $manager->persist($admin);

        // ========================
        // 🛍 Produits
        // ========================

        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setDescription('Description for product ' . $i);
            $product->setIsActive(true);
            $product->setStock(true);

            $manager->persist($product);
        }

        // ========================
        // 📂 Catégories
        // ========================

        $category1 = new Category();
        $category1->setNameCategory('Plat');
        $category1->setDescriptionCategory('Delicious dishes');
        $category1->setImageName('plat.jpg');
        $category1->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setNameCategory('Entrer');
        $category2->setDescriptionCategory('Delicious dishes');
        $category2->setImageName('entrer.jpg');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setNameCategory('Dessert');
        $category3->setDescriptionCategory('Delicious dishes');
        $category3->setImageName('dessert.jpg');
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setNameCategory('Boisson');
        $category4->setDescriptionCategory('Delicious dishes');
        $category4->setImageName('boisson.jpg');
        $manager->persist($category4);

        // ========================
        $manager->flush();
    }
}