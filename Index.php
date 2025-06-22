<?php

// Redirecionar para HTTPS se a requisição não estiver usando HTTPS
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
  $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: ' . $redirect);
  exit();
}

require_once __DIR__.'/app/Core/Core.php';
require_once __DIR__.'/app/router/routes.php';

spl_autoload_register(function($file) {
  $file = strtolower($file);
  if (file_exists(__DIR__."/app/utils/$file.php")) {
    require_once __DIR__."/app/utils/$file.php";
  }
}); 

$core = new Core($routes); 
$core ->run($routes);
