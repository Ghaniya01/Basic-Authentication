<?php

use App\Objects\User;
use JetBrains\PhpStorm\NoReturn;

if(!function_exists('dd')){
    function dd(...$param):void{
        echo '<pre>';
        print_r($param);
        echo '</pre>';

        die();
    }
}

if(!function_exists('redirect')){
    #[NoReturn] function redirect($location):void{
        header('Location: '.$location);
        exit();
    }
}


if(!function_exists('user')){
   function user():?User{

       return $_SESSION['user'] ?? null;

    }
}