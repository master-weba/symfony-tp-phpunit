<?php

namespace App\Service;

class LogReaderService
{
    public function parseFile(){
        $json = file_get_contents("../".$_ENV['LOGS_FILE_PATH'].$_ENV["LOGS_FILE_NAME"]);
        return json_decode($json,true);
    }
}
