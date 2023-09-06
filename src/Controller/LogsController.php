<?php

namespace App\Controller;

use App\Entity\LogTrace;
use App\Service\LogReaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogsController extends AbstractController
{

    public function __construct(
        private LogReaderService $service
    )
    {
    }


    #[Route('/logs', name: 'app_logs')]
    public function index(): Response
    {
        try{
            $data = $this->service->getEntries($_ENV['LOGS_FILE_PATH'].$_ENV["LOGS_FILE_NAME"]);
            $data = array_map(function($entry){
                return new LogTrace(date_create_immutable($entry["date"]),$entry["type"],$entry["message"]);
            },$data);
            $parseError = false;
        }catch(FileNotFoundException $e){
            $data = [];
            $parseError = true;
        }

        return $this->render('logs/index.html.twig', [
            'logs' => $data,
            'parseError' => $parseError
        ]);
    }
}
