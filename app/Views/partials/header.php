<?php

$baseDir = dirname(__FILE__);
include $baseDir . "/../../utils/Database.php";

session_start();

// Verifica se há sessão
if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
  header("Location: /login-page");
  exit();
}

// Verifica se o token é válido
$stmt = $pdo->prepare("SELECT session_token FROM user_sessions WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$session = $stmt->fetch();

if (!$session || $session['session_token'] !== $_SESSION['token']) {
  session_destroy();
  header("Location: /login-page");
  exit();
}

// Dados do usuário
$IdUser    = decryptData($_COOKIE['id'], $encryptionKey);
$grupo     = decryptData($_COOKIE['grupo'], $encryptionKey);
$nivel     = decryptData($_COOKIE['nivel'], $encryptionKey);
$nomeUser  = decryptData($_COOKIE['usuario'], $encryptionKey);
$emailUser = decryptData($_COOKIE['email'], $encryptionKey);

if (!$IdUser) {
  header('Location: /login-page');
}

$estadosIBGE = [
  '12' => 'AC',
  '27' => 'AL',
  '13' => 'AM',
  '16' => 'AP',
  '29' => 'BA',
  '23' => 'CE',
  '53' => 'DF',
  '32' => 'ES',
  '52' => 'GO',
  '21' => 'MA',
  '31' => 'MG',
  '50' => 'MS',
  '51' => 'MT',
  '15' => 'PA',
  '25' => 'PB',
  '26' => 'PE',
  '22' => 'PI',
  '41' => 'PR',
  '33' => 'RJ',
  '24' => 'RN',
  '43' => 'RS',
  '11' => 'RO',
  '14' => 'RR',
  '42' => 'SC',
  '28' => 'SE',
  '35' => 'SP',
  '17' => 'TO'
];

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $nomeSistema ?></title>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.min.css" />
  <link rel="shortcut icon" type="image/x-icon" href="/app/public/imagens/favicon.png">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/css/adminlte.css">

  <style>
    .btn-success {
      background-color: <?php echo $corPrimaria ?> !important;
      border-color: <?php echo $corPrimaria ?> !important;
    }

    .btn-success:hover {
      background-color: <?php echo $corSecundaria ?> !important;
      border-color: <?php echo $corSecundaria ?> !important;
    }

  </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed pace-done">
  <script src="<?php echo $baseUrl ?>app/public/plugins/jquery/jquery.min.js"></script>

  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <p>Carregando...</p>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a id="<?php echo $baseUrl ?>editUsuario" href="usuario" class="nav-link">
            <i class="fas fa-user-circle"></i>
            <span class="d-none d-md-inline"><?php echo $nomeUser ?></span>
          </a>
        </li>

        <li class="nav-item ml-2">
          <div id="modoDark" class="nav-link custom-control custom-checkbox pt-1">
            <label class="theme-switch" for="checkbox" style="cursor:pointer;">
              <input type="checkbox" id="checkbox" style="display:none;">
              <div class="btn btn-dark btn-sm"><i class="fas fa-adjust"></i> Modo Escuro </div>
            </label>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i> Tela cheia
          </a>
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

  </div>