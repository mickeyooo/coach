<?php

namespace App\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("")
     */
    public function index()
    {
        return $this->render('manager/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
