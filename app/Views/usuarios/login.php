<?php

$baseDir = dirname(__FILE__);
include $baseDir . "/../../utils/Database.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='manifest' href='<?php echo $baseUrl ?>app/public/manifest.json'>

    <title><?php echo $nomeSistema ?></title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Fiel App">
    <link rel="apple-touch-icon" href="<?php echo $baseUrl ?>app/public/img/icons/ios.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.css">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/css/adminlte.min.css">
</head>

<body class="hold-transition login-page" style="background-image: linear-gradient(<?php echo  $corSecundaria . ',' . $corPrimaria ?>);">
    <div class="login-box">
        <div class="card rounded">
            <div class="card-header text-center" style="background: <?php echo $corPrimaria ?>">
                <?php
                    if ($urlLogo) {
                        echo '<img src="' . $baseUrl . $urlLogo . '" alt="' . $nomeSistema . '" class="p-3">';
                    } else {
                        echo '<h2 class="text-light">' . $nomeSistema . '</h2>';
                    }
                ?>
            </div>
            <div class="card-body  login-card-body">
                <h4 class="login-box-msg">Faça o seu login a baixo!</h4>
                <form id="login" action="" method="post">
                    <!-- <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite seu CPF" value="" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-hashtag"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha" value="" required>
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="button" onclick="toggleSenha()"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-primary btn-block border-0" style="background-color: <?php echo $corSecundaria ?>;">Login</button>
                        </div>
                    </div>
                </form>
                <div class="row mt-2">
                    <div class="col-6">
                        <p class="mb-1">
                            <a href="<?php echo $baseUrl ?>tela-resetarsenha">Esqueci minha senha</a>
                        </p>
                        <p class="mb-0">
                            <a href="<?php echo $baseUrl ?>registro" class="text-center">Cadastre-se</a>
                        </p>
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-app bg-dark btn-block m-0" id="install-button" style="border: none; border-radius: 10px;">
                            <i class="fab fa-android"></i> Instalar App
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <script src="<?php echo $baseUrl ?>app/public/plugins/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/js/adminlte.min.js"></script>
</body>

</html>

<script>
    function toggleSenha() {
        var senhaInput = document.getElementById("senha");
        if (senhaInput.type === "password") {
            senhaInput.type = "text";
        } else {
            senhaInput.type = "password";
        }
    }

    if ('Notification' in window) {
        Notification.requestPermission().then(function(permission) {
            if (permission === 'granted') {} else if (permission === 'denied') {
                Notification.requestPermission().then(function(permission) {
                    if (permission === 'granted') {
                        console.log('Permissão para notificações concedida!');
                    }
                });
            }
        });
    }

    $("#login").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');
        $.ajax({
            type: "POST",
            url: "<?php echo $baseUrl ?>login",
            data: {
                cpf: $("#cpf").val().replace(/\D/g, ''),
                senha: $("#senha").val(),
            },
            success: function(data) {
                if (data.resultado == 'erro') {
                    Notiflix.Notify.Failure(data.msg);
                    Notiflix.Loading.Remove();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else if (data.resultado == 'bloqueado') {
                    Notiflix.Loading.Remove();
                    Notiflix.Report.Warning(
                        'Atenção!',
                        'Seu usuário está inativo. Entre em contato com o administrador do sistema.',
                        'Ok');
                } else if (data.resultado == 'aguardando') {
                    Notiflix.Loading.Remove();
                    Notiflix.Report.Warning(
                        'Atenção!',
                        'Seu usuário está em analise por favor aguarde.',
                        'Ok');
                } else if (data.resultado == 'reprovado') {
                    Notiflix.Loading.Remove();
                    Notiflix.Report.Warning(
                        'Atenção!',
                        'Seu usuário foi reprovado favor entrar em contato com seu líder.',
                        'Ok');
                } else {
                    window.location.href = "<?php echo $baseUrl ?>";
                }
            },
            error: function(error) {
                console.error("Erro na requisição AJAX:", error);
            }
        });
    });

    // Para o Service Worker do PWA
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('app/public/sw.js')
            .then(function(registration) {
                console.log('Service Worker do PWA registrado com sucesso:', registration);
            })
            .catch(function(error) {
                console.error('Erro ao registrar o Service Worker do PWA:', error);
            });
    }

    // Para o Service Worker do Firebase Messaging
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('app/public/firebase-messaging-sw.js')
            .then(function(registration) {
                console.log('Service Worker do Firebase Messaging registrado com sucesso:', registration);
            })
            .catch(function(error) {
                console.error('Erro ao registrar o Service Worker do Firebase Messaging:', error);
            });
    }

    // Check to make sure Sync is supported.
    if ('serviceWorker' in navigator && 'SyncManager' in window) {

        // Get our service worker registration.
        const registration = navigator.serviceWorker.registration;

        try {
            // This is where we request our sync. 
            // We give it a "tag" to allow for differing sync behavior.
            registration.sync.register('database-sync');

        } catch {
            console.log("Background Sync failed.")
        }
    }

    // Query the user for permission.
    const periodicSyncPermission = navigator.permissions.query({
        name: 'periodic-background-sync',
    })

    // Check if permission was properly granted.
    if (periodicSyncPermission.state == 'granted') {

        // Register a new periodic sync.
        registration.periodicSync.register('fetch-new-content', {
            // Set the sync to happen no more than once a day.
            minInterval: 24 * 60 * 60 * 1000
        });
    }

    let deferredPrompt;
    const installButton = document.getElementById('install-button');
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        installButton.addEventListener('click', (e) => {
            //installButton.style.display = 'none';
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('Usuário aceitou a instalação');
                } else {
                    console.log('Usuário recusou a instalação');
                }
                deferredPrompt = null;
            });
        });
    });
</script>