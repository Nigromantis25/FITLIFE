<?php

namespace App\Controller\Recepcionista;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/recepcionista')]
#[IsGranted('ROLE_RECEPCIONISTA')]
class DashboardRecepcionistaController extends AbstractController
{
    #[Route('/dashboard', name: 'recepcionista_dashboard')]
    public function index(): Response
    {
        /** @var \App\Entity\Personal $user */
        $user = $this->getUser();

        return $this->render('recepcionista/dashboard.html.twig', [
            'usuario' => $user,
            'stats' => [
                'clientes_hoy'    => 14,
                'pagos_hoy'       => 7,
                'membresias_venc' => 5,
                'asistencias'     => 31,
            ],
        ]);
    }

    #[Route('/asistencias', name: 'recepcionista_asistencias')]
    public function asistencias(): Response
    {
        $asistencias = [
            ['cliente' => 'Marta López', 'fecha' => '2026-04-01', 'entrada' => '08:05', 'salida' => '09:20'],
            ['cliente' => 'Carlos Pérez', 'fecha' => '2026-04-01', 'entrada' => '09:10', 'salida' => '10:25'],
            ['cliente' => 'Ana Gómez', 'fecha' => '2026-04-01', 'entrada' => '10:15', 'salida' => '11:30'],
        ];

        return $this->render('recepcionista/asistencias.html.twig', [
            'asistencias' => $asistencias,
        ]);
    }

    #[Route('/reportes', name: 'recepcionista_reportes')]
    public function reportes(): Response
    {
        $reportes = [
            'asistencias_ultima_semana' => 184,
            'clientes_nuevos'           => 23,
            'ingresos'                  => 5870,
            'membresias_activas'        => 198,
        ];

        return $this->render('recepcionista/reportes.html.twig', [
            'reportes' => $reportes,
        ]);
    }
}