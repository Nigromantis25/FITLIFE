<?php

namespace App\Controller;

use App\Entity\Asistencia;
use App\Entity\Cliente;
use App\Repository\AsistenciaRepository;
use App\Repository\ClienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AsistenciaController extends AbstractController
{
    #[Route('/api/asistencia/registrar', name: 'api_asistencia_registrar', methods: ['POST'])]
    public function registrarAsistencia(
        Request $request,
        ClienteRepository $clienteRepo,
        AsistenciaRepository $asistenciaRepo,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['cedula'])) {
            return new JsonResponse(['error' => 'Cédula requerida'], Response::HTTP_BAD_REQUEST);
        }

        $cedula = $data['cedula'];
        $cliente = $clienteRepo->findOneByCedula($cedula);

        if (!$cliente) {
            return new JsonResponse(['error' => 'Cliente no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $today = new \DateTime('today');
        $asistenciasHoy = $asistenciaRepo->findByClienteAndFecha($cliente, $today);

        // Si ya tiene una asistencia sin salida registrada, registrar salida
        if (!empty($asistenciasHoy)) {
            $ultima = end($asistenciasHoy);
            if ($ultima->getHoraSalida() === null) {
                $ultima->setHoraSalida(new \DateTime());
                $em->flush();
                
                return new JsonResponse([
                    'mensaje' => 'Salida registrada',
                    'tipo' => 'salida',
                    'cliente' => $cliente->getNombre() . ' ' . $cliente->getApellido(),
                    'hora' => $ultima->getHoraSalida()->format('H:i:s'),
                ]);
            }
        }

        // Registrar entrada
        $asistencia = new Asistencia();
        $asistencia->setCliente($cliente);
        $asistencia->setFecha($today);
        $asistencia->setHoraEntrada(new \DateTime());
        
        $em->persist($asistencia);
        $em->flush();

        return new JsonResponse([
            'mensaje' => 'Entrada registrada',
            'tipo' => 'entrada',
            'cliente' => $cliente->getNombre() . ' ' . $cliente->getApellido(),
            'hora' => $asistencia->getHoraEntrada()->format('H:i:s'),
        ]);
    }

    #[Route('/asistencia/check-in/{cedula}', name: 'asistencia_check_in', methods: ['GET'])]
    public function checkIn(
        string $cedula,
        ClienteRepository $clienteRepo,
        AsistenciaRepository $asistenciaRepo,
        EntityManagerInterface $em
    ): Response {
        $cliente = $clienteRepo->findOneByCedula($cedula);

        if (!$cliente) {
            return $this->render('asistencia/check_error.html.twig', [
                'error' => 'Cliente no encontrado'
            ]);
        }

        $today = new \DateTime('today');
        $asistenciasHoy = $asistenciaRepo->findByClienteAndFecha($cliente, $today);

        if (!empty($asistenciasHoy)) {
            $ultima = end($asistenciasHoy);
            if ($ultima->getHoraSalida() === null) {
                $ultima->setHoraSalida(new \DateTime());
                $em->flush();
                
                return $this->render('asistencia/check_success.html.twig', [
                    'tipo' => 'salida',
                    'cliente' => $cliente,
                    'hora' => $ultima->getHoraSalida()->format('H:i:s'),
                ]);
            }
        }

        // Registrar entrada
        $asistencia = new Asistencia();
        $asistencia->setCliente($cliente);
        $asistencia->setFecha($today);
        $asistencia->setHoraEntrada(new \DateTime());
        
        $em->persist($asistencia);
        $em->flush();

        return $this->render('asistencia/check_success.html.twig', [
            'tipo' => 'entrada',
            'cliente' => $cliente,
            'hora' => $asistencia->getHoraEntrada()->format('H:i:s'),
        ]);
    }
}
