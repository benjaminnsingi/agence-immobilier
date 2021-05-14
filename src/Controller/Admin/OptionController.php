<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use App\Services\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/option')]
class OptionController extends AbstractController
{
    private MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    #[Route('/', name: 'option_index', methods: ['GET'])]
    public function index(OptionRepository $optionRepository): Response
    {
        return $this->render('admin/option/index.html.twig', [
            'options' => $optionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'option_new', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();
            $this->messageService->addSuccess('Option ajoutée avec succès ');

            return $this->redirectToRoute('option_index');
        }

        return $this->render('admin/option/new.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'option_show', methods: ['GET'])]
    public function show(Option $option): Response
    {
        return $this->render('admin/option/show.html.twig', [
            'option' => $option,
        ]);
    }

    #[Route('/{id}/edit', name: 'option_edit', methods: ['GET', 'POST'])]
    public function update(Request $request, Option $option): Response
    {
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->messageService->addSuccess('Option mis à jour avec succès');

            return $this->redirectToRoute('option_index');
        }

        return $this->render('admin/option/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'option_delete', methods: ['POST'])]
    public function delete(Request $request, Option $option): Response
    {
        if ($this->isCsrfTokenValid('delete'.$option->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($option);
            $entityManager->flush();
            $this->messageService->addSuccess('Option supprimée avec succès');
        }

        return $this->redirectToRoute('option_index');
    }
}
