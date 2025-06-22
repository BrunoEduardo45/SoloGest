<?php

function loadView($view, $tabela, $args = [], $loadHeader = true, $loadFooter = true)
{
    extract($args);

    $baseDir = dirname(__FILE__);
    $baseDir = $baseDir.'/../Views/partials/';

    if ($loadHeader) {
        require_once $baseDir . "/header.php";
    }

    require_once $baseDir . "/../".strtolower($tabela)."/".strtolower($view).".php";

    if ($loadFooter) {
        require_once $baseDir . "/footer.php";
    }
}