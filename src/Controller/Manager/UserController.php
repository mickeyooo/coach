<?php

namespace App\Controller\Manager;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("")
     */
    public function index()
    {
        return $this->render('manager/user/index.html.twig', [
            'title' => '用户列表',
            'list'  => $this->userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create")
     */
    public function create(Request $request)
    {
        $form = $this->createForm(UserType::class);

        $form->remove('avatarFile');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $this->userRepository->encryptPassword($user);
            $this->userRepository->save($user);

            return $this->redirectToRoute('app_manager_user_index');
        }

        return $this->render('manager/user/create.html.twig', [
            'title' => '创建新用户',
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile")
     */
    public function profile(Request $request)
    {
        $form = $this->createForm(UserType::class, $this->getUser());

        $form
            ->remove('roles')->remove('mobile')->remove('password')
            ->add('crop', null, ['mapped' => false])
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->update($form->getData());
        }

        return $this->render('manager/user/profile.html.twig', [
            'title' => '个人信息',
            'form'  => $form->createView(),
        ]);
    }
}
