<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->findAll();

        return $this->render('home/index.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/number/{id}', name: 'new_number')]
    public function newNumber($id): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->findOneById($id);

        $contact->setTelephone('New Number');

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/delete/{id}', name: 'del_contact')]
    public function delContact($id): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->findOneById($id);

        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
