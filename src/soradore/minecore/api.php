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

    public function __construct(string $url,string $token){
        $this->url = $url;
        $this->token = $token;
    }

    public function isOk(){
        $url = $this->url;
        $result = Utils::postURL("{$url}?check=true", []);
        switch($result){
            case 'ok':
            case 'true':
            case 'success':
                $return = true;
                break;
            default:
                $return = false;
        }
        return $return;
    }

    public function sendData(array $data){
        $url = $this->url;
        $token = $this->token; 
        Utils::postURL("{$url}?token={$token}", $data);
    }
}
       