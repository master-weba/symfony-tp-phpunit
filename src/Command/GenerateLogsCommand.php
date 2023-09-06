<?php

namespace App\Command;

use DateInterval;
use DatePeriod;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'generate-logs',
    description: 'Generate logs.json files',
)]
class GenerateLogsCommand extends Command
{

    private const DATES_LIMITS = ["start"=>"2023-09-01","end"=>"2023-09-05"];
    private const TYPES = ["error","info","success","warning"];

    /**
     * @return void
     */
    protected function configure(): void
    {
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->generateLogsData();
        if(file_exists($_ENV["LOGS_FILE_PATH"]) === true){
            $io->error("File already exists.");
            return Command::FAILURE;
        }

        if(is_dir($_ENV["LOGS_FILE_PATH"]) === false){
            mkdir($_ENV["LOGS_FILE_PATH"]);
        }

        file_put_contents($_ENV["LOGS_FILE_PATH"].$_ENV["LOGS_FILE_NAME"],$this->generateLogsData());


        $io->success('File successfully generated !');

        return Command::SUCCESS;
    }

    /**
     * @return bool|string
     */
    private function generateLogsData(): bool|string
    {
        $entries = [];
        $start_date = date_create_immutable(self::DATES_LIMITS["start"]);
        $end_date = date_create_immutable(self::DATES_LIMITS["end"]);

        $interval = DateInterval::createFromDateString('2 hours');
        $daterange = new DatePeriod($start_date, $interval ,$end_date);

        foreach($daterange as $date){

            $type = $this->grabType();
            $message=$this->getRandomMessageForType($type);

            $entries[] = [
                "date"=>$date->format('Y-m-d H:i'),
                "type"=>$type,
                "message"=>$message
            ];

        }

        return json_encode($entries,JSON_PRETTY_PRINT);

    }

    /**
     * @return string
     */
    private function grabType(): string
    {
        $typeKey = array_rand(self::TYPES,1);
        return self::TYPES[$typeKey];
    }

    /**
     * @param string $type
     * @return string
     */
    private function getRandomMessageForType(string $type): string{

        $messages = [
            "error"=>[
                "Access denied.",
                "Disk usage exceed limits.",
                "Invalid request parameter format.",
                "User does not exist.",
                "Memory"
            ],
            "warning"=>[
                "High memory peak detected.",
                "Low available disk space."
            ],
            "info"=>[
                "Data backup successfully end",
                "Data imported successfully"
            ],
            "success"=>[
                "User authenticate with success",
                "User successfully updated",
                "Payment proceed successfully"
            ],
        ];

        return $messages[$type][array_rand($messages[$type],1)];
    }
}
