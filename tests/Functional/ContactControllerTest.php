<?php

namespace App\Tests\Functional;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function PHPUnit\Framework\assertNull;

class ContactControllerTest extends WebTestCase
{
    public function testPage():void
    {
        $client = static::createClient();
        $client->request('GET', '/contact');

        $this->assertResponseIsSuccessful();
    }

    public function testNewPage():void
    {
        $client = static::createClient();
        $client->request('GET', '/contact/new');

        $this->assertResponseIsSuccessful();
    }

     public function testEditPage():void
    {
        
        $client = static::createClient();
        $client->request('GET', '/contact/2/edit');

        $this->assertResponseIsSuccessful();
    }

    public function testCreerContact():void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

            $crawler = $client->request('GET', '/contact/new');

            $form = $crawler->selectButton('Save')->form([
                'contact[nom]' => 'nom Form',
                'contact[prenom]' => 'prenom Form',
                'contact[email]' => 'test@test.com', 
                'contact[commentaire]' => 'commentaire Form',
            ]);

            $client->submit($form);
            $this->assertResponseRedirects();

            // Suivre la redirection pour vérifier que le contact a bien été créé
            $client->followRedirect();

            // Vérifier que le nom du contact apparaît dans table
            $this->assertSelectorTextContains('table', 'nom Form');
    }

   public function testFormulaireInvalideEmailVide(): void
{
    $client = static::createClient();
    $entityManager = static::getContainer()
        ->get('doctrine')
        ->getManager();

    // Nombre avant
    $beforeCount = count(
        $entityManager->getRepository(Contact::class)->findAll()
    );

    $crawler = $client->request('GET', '/contact/new');

    $form = $crawler->selectButton('Save')->form([
        'contact[nom]' => 'Nom Test',
        'contact[prenom]' => 'Prenom Test',
        'contact[email]' => '', 
        'contact[commentaire]' => 'Commentaire Test',
    ]);

    $client->submit($form);

    // ✅ pas de redirection
    $this->assertResponseStatusCodeSame(422);

    // ✅ vérifie erreur
    $this->assertSelectorExists('#contact_email_error1');

    // Nombre après
    $afterCount = count(
        $entityManager->getRepository(Contact::class)->findAll()
    );

    // ✅ rien ajouté
    $this->assertSame($beforeCount, $afterCount);
}
}