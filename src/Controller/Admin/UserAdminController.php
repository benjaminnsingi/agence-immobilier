<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\UserUpdateType;
use App\Services\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin")]
class UserAdminController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private MessageService $messageService;

    public function __construct(MessageService $messageService, EntityManagerInterface $entityManager)
    {
        $this->messageService = $messageService;
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'admin_user_list')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $data = $this->getDoctrine()->getRepository(User::class)->findBy([], ['id' => 'asc']);
        $users = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );
       return $this->render('admin/user/index.html.twig',[
          'users' => $users
       ]);
    }

    #[Route('/{id}/update', name: 'admin_edit_user',  methods: ["GET", "POST"])]
    public function update(Request $request, User $user): Response
    {
       $form = $this->createForm(UserUpdateType::class, $user);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           //$this->getDoctrine()->getManager()->flush();
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($user);
           $entityManager->flush();

           $this->messageService->addSuccess('Utilisateur mis à jour ');
           return $this->redirectToRoute('admin_user_list');
       }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'admin_delete_list',  methods: ["DELETE"])]
    public function delete(User $user, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $this->messageService->addSuccess('utilisateur supprimé avec succès.');
        }

        return $this->redirectToRoute('admin_user_list');
    }
}