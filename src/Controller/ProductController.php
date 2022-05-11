<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        // $contact = $this->entityManager->getRepository(Contact::class)->findOneById(1);
        // $contact = new Contact();
        // $contact->setNom('Durand');
        // $contact->setPrenom('Hugo');
        // $contact->setTelephone('0783730283');
        // $contact->setAdresse('test@gmail.com');
        // $contact->setVille('Melun');
        // $contact->setAge(30);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $this->render('product/index.html.twig');
    }
}
