<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo): bool{
    if($actual !== $proximo){
        return true;
    }
    return false;
}

// Revisa que el usuario esta Autenntificado

function isAuth() : void{
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

// Revisa que es un Admin
function isAdmin() : void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}