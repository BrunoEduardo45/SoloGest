<?php

$baseDir = dirname(__FILE__);
include $baseDir . "/../../utils/Database.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro - <?php echo $nomeSistema ?></title>
    <link rel="apple-touch-icon" href="<?php echo $baseUrl ?>app/public/img/icons/ios.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.css">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/css/adminlte.min.css">

    <style>
        .login-box {
            width: 600px;
            margin: auto;
        }
    </style>
</head>

<body class="hold-transition login-page" style="background-image: linear-gradient(<?php echo $corSecundaria . ',' . $corPrimaria ?>);">
    <div class="login-box">
        <div class="card mt-5 mb-5">
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
                <h4 class="w-100 text-center">Realize seu cadastro</h4>

                <form id="cadastro" method="post" class="row">
                    <div class="form-group col-12">
                        <label for="nome">Nome completo</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="cpf_cnpj">CPF ou CNPJ</label>
                        <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="grupo">Grupo</label>
                        <select name="grupo" id="grupo" class="form-control">
                            <option value="">Selecione um grupo</option>
                            <?php
                            $grupos = selecionarDoBanco('grupos', '*', 'status = 1');
                            foreach ($grupos as $grupo) {
                                echo "<option value='{$grupo['id']}'>{$grupo['nome']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="">Carregando estados...</option>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="cidade">Cidade</label>
                        <select name="cidade" id="cidade" class="form-control" required disabled>
                            <option value="">Selecione o estado primeiro</option>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="celular">Celular</label>
                        <input type="text" class="form-control" name="celular" id="celular" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="sexo">Sexo</label>
                        <select class="form-control" id="sexo" name="sexo">
                            <option value="">Selecione</option>
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="senha">Senha</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="senha" name="senha">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" onclick="toggleSenha()"><i class="far fa-eye"></i></button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="Acao" value="salvar">
                    <button type="submit" id="btnCadatro" class="btn btn-primary btn-block">Cadastrar</button>
                </form>


                <p class="mb-0 w-100 text-center mt-2">
                    <a href="<?php echo $baseUrl ?>" class="text-center">Já tenho cadastro</a>
                </p>
            </div>
        </div>
    </div>

    <script src="<?php echo $baseUrl ?>app/public/plugins/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/js/adminlte.min.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/plugins/inputmask/jquery.inputmask.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {
        // Máscaras
        $('#cpf_cnpj').inputmask({
            mask: ['999.999.999-99', '99.999.999/9999-99'],
            keepStatic: true
        });
        $('#celular').inputmask('(99) 99999-9999');

        // Carregar estados
        $.get('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome', function(data) {
            $('#estado').empty().append('<option value="">Selecione o estado</option>');
            data.forEach(function(estado) {
                $('#estado').append(`<option value="${estado.id}">${estado.nome}</option>`);
            });
        });

        // Carregar cidades quando um estado for selecionado
        $('#estado').on('change', function() {
            let estadoId = $(this).val();
            $('#cidade').empty().append('<option value="">Carregando cidades...</option>').prop('disabled', true);

            if (estadoId) {
                $.get(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`, function(data) {
                    $('#cidade').empty().append('<option value="">Selecione a cidade</option>').prop('disabled', false);
                    data.forEach(function(cidade) {
                        $('#cidade').append(`<option value="${cidade.nome}">${cidade.nome}</option>`);
                    });
                });
            }
        });
    });

    function toggleSenha() {
        var senhaInput = document.getElementById("senha");
        if (senhaInput.type === "password") {
            senhaInput.type = "text";
        } else {
            senhaInput.type = "password";
        }
    }

    function Dados() {
        return {
            usu_nome: $('#nome').val(),
            usu_cpf_cnpj: $('#cpf_cnpj').val().replace('-', '').replace('.', '').replace('/', ''),
            usu_grupo_id: $('#grupo').val(),
            usu_estado: $('#estado option:selected').text(),
            usu_cidade: $('#cidade').val(),
            usu_email: $('#email').val(),
            usu_celular: $('#celular').val(),
            usu_sexo: $('#sexo').val(),
            usu_senha: $('#senha').val(),
            usu_nivel: 3,
            usu_status: 1,
        };
    }

    $("#cadastro").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        var email = $("#email").val();
        var acao = 'verificar';

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/verificar",
            data: {
                email: email,
                Acao: acao
            },
            success: function(data) {

                if (data.acao == 'ok') {
                    $("#email").addClass('is-valid');
                    $("#email").removeClass('is-invalid');

                    $.ajax({
                        type: "POST",
                        url: "/inserir-usuario",
                        data: {dados: Dados()},
                        success: function(data) {
                            if (data.success != '') {
                                Notiflix.Loading.Remove();
                                Notiflix.Report.Success(
                                    'Sucesso!',
                                    'Seu cadastro foi realizado com sucesso! Aguarde liberação da nossa equipe de suporte.',
                                    'Ok',
                                    function() {
                                        window.location.href = "<?php echo $baseUrl ?>";
                                    }
                                );
                            } else {
                                Notiflix.Loading.Remove();
                                Notiflix.Notify.Failure(data.msg);
                                return false;
                            }
                        },
                        error: function(error) {
                            console.error("Erro na requisição AJAX:", error);
                        }
                    });

                } else {
                    Notiflix.Loading.Remove();
                    $("#email").addClass('is-invalid');
                    $("#email").removeClass('is-valid');
                    Notiflix.Notify.Failure('Este e-mail já existe em nossa base!');
                    $("#email").focus();
                    return false;
                }

            },
            error: function(error) {
                Notiflix.Loading.Remove();
                console.error("Erro na requisição AJAX:", error);
            }
        });
    });
</script>