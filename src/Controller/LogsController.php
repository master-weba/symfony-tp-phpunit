<?php

namespace App\Controller;

use App\Service\LogReaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogsController extends AbstractController
{
    #[Route('/logs', name: 'app_logs')]
    public function index(): Response
    {
        $service = new LogReaderService();

        $data = $service->parseFile();

        return $this->render('logs/index.html.twig', [
            'logs' => $data,
        ]);
    }
}
