<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/contact', name:'api_contact', methods:['POST'])]
class ContactController extends AbstractController
{
    public function __invoke(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
            return new JsonResponse(['status'=>'error','message'=>'Tous les champs sont requis'], 400);
        }

        $contact = new Contact();
        $contact->setName($data['name']);
        $contact->setEmail($data['email']);
        $contact->setMessage($data['message']);

        $em->persist($contact);
        $em->flush();

        return new JsonResponse(['status'=>'success','message'=>'Message enregistré en base !']);
    }
}