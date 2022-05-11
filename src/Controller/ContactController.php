<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contact/{id}', name: 'app_contact')]
    public function index($id): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->findOneById($id);

        return $this->render('contact/index.html.twig', [
            'contact' => $contact
        ]);
    }
}
