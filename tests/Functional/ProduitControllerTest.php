<?php

namespace App\Tests;

use App\Entity\Category;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduitControllerTest extends WebTestCase
{

    public function testSomething(): void
    {
         $client = static::createClient();

        $entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

      
        $category = $entityManager->getRepository(Category::class)->find(1);
        $this->assertNotNull($category, "Catégorie non trouvée");

        $client = static::createClient();
        $crawler = $client->request('GET', '/product/new');

       

        $form = $crawler->selectButton('Save')->form([
            'product[name]' => 'Mon Produit',
            'product[category]' => $category->getId(),

            
        ]);

        $client->submit($form);
        $this->assertResponseRedirects();

        
    }
}
