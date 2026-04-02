<?php

namespace App\Tests\Integration;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactDoctrineTest extends KernelTestCase
{
    public function testPersistContact():void
    {
        self::bootKernel();
        $em = static::getContainer()->get('doctrine')->getManager();
        // $validator = static::getContainer()->get('validator');

        $contact = new Contact();
        $contact->setNom('NomPersist');
        $contact->setPrenom("PrenomPersist");
        $contact->setEmail("persittest.com");
        $contact->setCommentaire("Commentaire test");

        // $catchedConstraints = $validator->validate($contact);
        // $this->assertCount(0, $catchedConstraints);

        $em->persist($contact);
        $em->flush();

        self::assertNotNull($contact->getId());


    }
}