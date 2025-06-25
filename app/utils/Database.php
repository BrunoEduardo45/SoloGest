<?php 

date_default_timezone_set('America/Sao_Paulo');

// // Telegram ----------------------------------------------------------------
// $TokenTelegram = "6811203397:AAFUFZCN19d6Ix-3blmIXkFq6BRx-TkoTIY";
// $chatIdTelegram = "-1002074817656";

// Chave de criptografia ---------------------------------------------------
$encryptionKey = ";&%~mvLfd[QeSxI";

// DB Conection ------------------------------------------------------------
global $pdo;
$host       = 'localhost';
$db         = 'bd_sologest';
$login      = 'root';
$password   = '';

// buscar dados do Sistema -------------------------------------------------
try {
    $pdo = new PDO(
      "mysql:host=$host;dbname=" . $db, $login, $password, 
      array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    $stmt = $pdo->query("SELECT * FROM sistema LIMIT 1");
    $stmt->execute();
    $config = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($config as $values) {
        $nomeSistema        = (isset($values['sis_nome']) ? $values['sis_nome'] : "");
        $descricaoSistema   = (isset($values['sis_descricao']) ? $values['sis_descricao'] : "");
        $baseUrl            = (isset($values['sis_base_url']) ? $values['sis_base_url'] : "");
        $urlLogo            = (isset($values['sis_url_logo']) ? $values['sis_url_logo'] : "");
        $emailPadrao        = (isset($values['sis_email']) ? $values['sis_email'] : "");
        $nomeEmpresa        = (isset($values['sis_empresa']) ? $values['sis_empresa'] : "");
        $siteEmpresa        = (isset($values['sis_url_empresa']) ? $values['sis_url_empresa'] : "");
        $versao             = (isset($values['sis_versao']) ? $values['sis_versao'] : "");
        $corPrimaria        = (isset($values['sis_cor_primaria']) ? $values['sis_cor_primaria'] : "");
        $corSecundaria      = (isset($values['sis_cor_secundaria']) ? $values['sis_cor_secundaria'] : "");
        $corBackground      = (isset($values['sis_cor_bg']) ? $values['sis_cor_bg'] : "");
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Não foi possível conectar, tente novamente mais tarde!';
}