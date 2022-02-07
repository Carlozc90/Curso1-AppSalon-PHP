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

// Revisa que el usuario esta Autenntificado

function isAuth() : void{
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}