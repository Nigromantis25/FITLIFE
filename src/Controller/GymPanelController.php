<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GymPanelController extends AbstractController
{
    #[Route('/panel-gimnasio', name: 'gimnasio_panel')]
    public function index(): Response
    {
        return $this->render('gimnasio/panel.html.twig');
    }
}
