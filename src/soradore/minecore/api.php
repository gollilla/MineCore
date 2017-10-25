<?php

   /**  
    *   __  __ _               ____               
    *  |  \/  (_)_ __   ___   / ___|___  _ __ ___ 
    *  | |\/| | | '_ \ / _ \ | |   / _ \| '__/ _ \
    *  | |  | | | | | |  __/ | |__| (_) | | |  __/
    *  |_|  |_|_|_| |_|\___|  \____\___/|_|  \___|
    *
    *
    *   @author soradore
    *
    *
    *
    **/                                         

namespace soradore\minecore;

/* NetWork */
use pocketmine\utils\Utils;

class API{

    define("WEB_API_URL", "https://sample.com/api.php");
    define("WEB_API_TOKEN", "");

    public function sendData(array $data){
        Utils::postURL(WEB_API_URL.'?token='.WEB_API_TOKEN, $data);
    }
}
       