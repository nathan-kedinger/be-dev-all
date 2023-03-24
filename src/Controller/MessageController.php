<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageFormType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function inbox(MessageRepository $messageRepository): Response
    {
        $user = $this->getUser();
        $messages = $messageRepository->findByRecipient($user);

        return $this->render('message/inbox.html.twig', [
            'messages' => $messages,
        ]);
    }

    #[Route('/outbox', name: 'app_outbox')]
    public function outbox(MessageRepository $messageRepository): Response
    {
        $user = $this->getUser();
        $messages = $messageRepository->findBySender($user);

        return $this->render('message/outbox.html.twig', [
            'messages' => $messages,
        ]);
    }

    #[Route('/message/{id}', name: 'app_message_show')]
    public function show(Message $message): Response
    {
        $user = $this->getUser();
        if ($message->getSender() !== $user && $message->getRecipient() !== $user) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de voir ce message.");
        }

        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/message/create', name: 'app_message_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageFormType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $message->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('message_show', ['id' => $message->getId()]);
        }

        return $this->render('message/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
