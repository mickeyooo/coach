<?php

namespace App\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("menu")
 */
class MenuController extends AbstractController
{
    /**
     * @Route("")
     */
    public function index()
    {
        return $this->render('manager/menu/index.html.twig', [
            'title' => '菜单管理',
        ]);
    }
}
