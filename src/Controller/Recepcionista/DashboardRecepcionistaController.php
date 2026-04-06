<?php

namespace App\Controller\Recepcionista;

use App\Repository\AsistenciaRepository;
use App\Repository\ClienteRepository;
use App\Repository\MembresiaClienteRepository;
use App\Repository\PagoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/recepcionista')]
#[IsGranted('ROLE_RECEPCIONISTA')]
class DashboardRecepcionistaController extends AbstractController
{
    #[Route('/dashboard', name: 'recepcionista_dashboard')]
    public function index(AsistenciaRepository $asistenciaRepo, ClienteRepository $clienteRepo): Response
    {
        /** @var \App\Entity\Personal $user */
        $user = $this->getUser();

        $asistenciasHoy = $asistenciaRepo->findByToday();
        $clientesActivos = $asistenciaRepo->findActiveClientes();

        return $this->render('recepcionista/dashboard.html.twig', [
            'usuario' => $user,
            'stats' => [
                'clientes_hoy'    => count($asistenciasHoy),
                'pagos_hoy'       => 7, // TODO: Implementar contador de pagos
                'membresias_venc' => 5, // TODO: Implementar contador de membresías vencidas
                'asistencias'     => $asistenciaRepo->countToday(),
            ],
            'clientes_activos' => $clientesActivos,
        ]);
    }

    #[Route('/asistencias', name: 'recepcionista_asistencias')]
    public function asistencias(AsistenciaRepository $asistenciaRepo): Response
    {
        $asistencias = $asistenciaRepo->findAllWithClientes();

        return $this->render('recepcionista/asistencias.html.twig', [
            'asistencias' => $asistencias,
        ]);
    }

    #[Route('/reportes', name: 'recepcionista_reportes')]
    public function reportes(AsistenciaRepository $asistenciaRepo, ClienteRepository $clienteRepo): Response
    {
        $asistenciasUltimaSemana = $asistenciaRepo->findByLastDays(7);
        $totalClientes = $clienteRepo->countActive();
        $clientesActivos = $asistenciaRepo->findActiveClientes();

        $reportes = [
            'asistencias_ultima_semana' => count($asistenciasUltimaSemana),
            'clientes_nuevos'           => 0, // TODO: Implementar contador de clientes nuevos
            'ingresos'                  => 0, // TODO: Implementar suma de pagos
            'clientes_activos'          => count($clientesActivos),
            'clientes_totales'          => $totalClientes,
        ];

        return $this->render('recepcionista/reportes.html.twig', [
            'reportes' => $reportes,
        ]);
    }
}