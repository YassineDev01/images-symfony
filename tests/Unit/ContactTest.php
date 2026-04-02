<?php

namespace App\Tests\Unit;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase 
{
    public function testNom():void
    {
        $contact = new Contact();
        $contactNom = "testUnitNom";
        $contact->setNom($contactNom);

        self::assertSame($contactNom, $contact->getNom());
       
    }

    public function testPrenom():void
    {
        $contact = new Contact();
        $contactPrenom = "testUnitPrenom";
        $contact->setPrenom($contactPrenom);

        self::assertSame($contactPrenom, $contact->getPrenom());
    }

    public function testEmail():void
    {
        $contact = new Contact();
        $contactEmail = "testUnit@Email";
        $contact->setEmail($contactEmail);

        self::assertSame($contactEmail, $contact->getEmail());
    }

    public function testCommentaire():void
    {
        $contact = new Contact();
        $contactText = "testUnitText";
        $contact->setCommentaire($contactText);

        self::assertSame($contactText, $contact->getCommentaire());
    }
}