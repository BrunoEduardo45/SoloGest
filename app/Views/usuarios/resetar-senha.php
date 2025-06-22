<?php

$baseDir = dirname(__FILE__);
include $baseDir . "/../../utils/Database.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Resetar Senha - <?php echo $nomeSistema ?></title>
  <link rel="apple-touch-icon" href="<?php echo $baseUrl ?>app/public/img/icons/ios.png">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/css/adminlte.min.css">
</head>

<body class="hold-transition login-page" style="background-image: linear-gradient(<?php echo $corSecundaria . ',' . $corPrimaria ?>);">
<script src="//code.tidio.co/dkrqk8uirfixtqtq9wslneswlmbh4bqi.js" async></script>
<div class="login-box">
    <div class="card">
      <div class="card-header text-center" style="background: <?php echo $corPrimaria ?>">
      <?php
        if ($urlLogo) {
            echo '<img src="' . $baseUrl . $urlLogo . '" alt="' . $nomeSistema . '">';
        } else {
            echo '<h2 class="text-light">' . $nomeSistema . '</h2>';
        }
      ?>
      </div>
      <div class="card-body login-card-body">
        <p class="login-box-msg">Digite seu CPF/CNPJ para redefinir sua senha de acesso.</p>

        <form id="resetarSenha" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="cpf_cnpj" name="cpf" placeholder="CPF/CNPJ" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-hashtag"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mb-2">
              <input type="hidden" name="Acao" value="resetarSenha">
              <button type="submit" class="btn btn-primary btn-block">Resetar senha</button>
              <a href="<?php echo $baseUrl ?>" class="btn btn-warning btn-block">Voltar</a>
            </div>
          </div>
        </form>

        <p class="mb-1 w-100 text-center mt-2">
          <a href="<?php echo $baseUrl ?>">Fazer login</a>
        </p>

      </div>
    </div>
  </div>

<script src="<?php echo $baseUrl ?>app/public/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.7/dist/inputmask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/js/adminlte.min.js"></script>

</body>

</html>

<script>
  $(document).ready(function(){
    var im = new Inputmask({
      mask: ['999.999.999-99', '99.999.999/9999-99'],
      keepStatic: true
    });

    $('#cpf_cnpj').each(function() {
      im.mask(this);
    });

    $('#cpf_cnpj').on('input', function() {
      var valor = $(this).val().replace(/\D/g, '');

      if (valor.length <= 11) {
        $(this).inputmask('mask', '999.999.999-99');
      } else {
        $(this).inputmask('mask', '99.999.999/9999-99');
      }
    });
  });

  $("#resetarSenha").submit(function(e) {
    e.preventDefault();
    Notiflix.Loading.Pulse('Carregando...');
    $.ajax({
      type: "POST",
      url: "/resetar-senha",
      data: {
        cpf: $("#cpf_cnpj").val().replace(/\D/g, '')
      },
      success: function(data) {
        if (data.acao == 'ok') {
          Notiflix.Report.Success('Sucesso!','Sua senha foi resetada com sucesso','Ok',
          function(){
            window.location.href = "./";
          });
          Notiflix.Loading.Remove();
        } else {
          Notiflix.Report.Failure('CPF/CNPJ Invalido','Este CPF/CNPJ não existe em nossa base','Ok');
          Notiflix.Loading.Remove();
        }
      }
    });
  });
</script>