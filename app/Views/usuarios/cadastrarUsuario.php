<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <form id="formUsu" method="post">
                        <div class="card card-outline card-primary">

                            <div class="card-body">
                                <h3>Informações do Usuario</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="form-label" for="nome">Nome Completo</label>
                                            <input type="text" class="form-control" name="nome" id="nome" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="cpf_cnpj">CPF ou CNPJ</label>
                                            <input type="cpf_cnpj" class="form-control cpf_cnpj" id="cpf_cnpj" name="cpf_cnpj" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="celular">Celular</label>
                                            <input type="text" class="form-control celular" name="celular" id="celular" placeholder="(99) 9999-9999" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="dataNascimento">Data de Nascimento</label>
                                            <input type="date" class="form-control dataNascimento" id="dataNascimento" name="dataNascimento" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label" for="sexo">Sexo</label>
                                            <select class="form-control" name="sexo" id="sexo" required>
                                                <option value="masculino">Masculino</option>
                                                <option value="feminino">Feminino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Nível de Usuário</label>
                                            <select class="form-control" name="tipo" id="tipo" required>
                                                <?php
                                                $list = selecionarDoBanco("tipo_usuario", "*", "tp_status = 1 order by tp_id desc");
                                                foreach ($list as $values) {
                                                ?>
                                                    <option value="<?php echo $values['tp_id'] ?>"><?php echo $values['tp_nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="Status" id="Status" name="Status">
                                                <?php
                                                $list = selecionarDoBanco("status", "*", "sts_status = 1");
                                                foreach ($list as $values) {
                                                ?>
                                                    <option value="<?php echo $values['sts_id'] ?>"><?php echo $values['sts_nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label" for="senha">Senha</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="senha" name="senha" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button" onclick="toggleSenha()"><i class="far fa-eye"></i></button>
                                            </div>
                                            <div class="invalid-feedback">
                                                Atenção! As senhas não estão iguais.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right py-3">
                                <input type="hidden" id="Acao" name="Acao" value="salvar">
                                <a href="<?php echo $baseUrl ?>usuarios" class="btn btn-warning"><i class="fa fa-arrow-left mr-2"></i> Voltar</a>
                                <button type="submit" class="btn btn-primary">Salvar <i class="fa fa-save ml-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function Dados() {
        return {
            usu_nome: $('#nome').val(),
            usu_cpf_cnpj: $('#cpf_cnpj').val().replace('-', '').replace('.', '').replace('/', ''),
            usu_grupo_id: $('#grupo').val(),
            usu_email: $('#email').val(),
            usu_celular: $('#celular').val(),
            usu_dataNascimento: $('#dataNascimento').val(),
            usu_sexo: $('#sexo').val(),
            usu_senha: $('#senha').val(),
            usu_nivel: $('#tipo').val(),
            usu_status: $('#Status').val(),
        };
    }

    function toggleSenha() {
        var senhaInput = document.getElementById("senha");
        if (senhaInput.type === "password") {
            senhaInput.type = "text";
        } else {
            senhaInput.type = "password";
        }

        var senhaInput = document.getElementById("confirmarSenha");
        if (senhaInput.type === "password") {
            senhaInput.type = "text";
        } else {
            senhaInput.type = "password";
        }
    }

    $("#formUsu").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        $.ajax({
            type: "POST",
            url: "/inserir-usuario",
            data: {
                dados: Dados(),
            },
            success: function(data) {
                if (data.success != '') {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success('Membro cadastrado com Sucesso!');
                    setTimeout(function() {
                        window.location.href = '/usuarios';
                    }, 2000);
                } else {
                    Notiflix.Notify.Failure(data.msg);
                    Notiflix.Loading.Remove();
                }
            },
            error: function(error) {
                console.error("Erro na requisição AJAX:", error);
            }
        });
    });
</script>