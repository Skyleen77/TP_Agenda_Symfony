<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contact/get/{id}', name: 'app_contact')]
    public function index($id): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->findOneById($id);

        return $this->render('contact/index.html.twig', [
            'contact' => $contact
        ]);
    }

    #[Route('/contact/add', name: 'contact_add')]
    public function add(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
        }

        return $this->render('contact/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/contact/modifier/{id}', name: 'contact_update')]
    public function update(Request $request, $id): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->findOneById($id);
        
        if ($contact)
        {
            return $this->redirectToRoute('contact_add');
        }$form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
        }

        return $this->render('contact/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
