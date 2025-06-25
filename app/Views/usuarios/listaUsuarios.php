<?php

$joins = [
    'INNER JOIN tipo_usuario ON (usu_nivel = tp_id)',
    'INNER JOIN status ON (sts_id = usu_status)'
];

$where = '';

if ($busca != '') {
    $where = "sts_nome = '" . ucfirst($busca) . "'";
}

$list = selecionarDoBanco('usuarios', '*', $where, [], $joins);
$count = count($list);

?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Usuarios</h3>
                        <hr>
                        <div class="col-md-12">
                            <?php if ($count > 0) { ?>
                                <div class="table-responsive">
                                    <table id="table" class="table table-hover table-sm w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">ID</th>
                                                <th style="width: 20%">Nome</th>
                                                <th style="width: 20%">Email</th>
                                                <th style="width: 15%">Celular</th>
                                                <th style="width: 10%">Tipo</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 15%">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody class="row_position">
                                            <?php foreach ($list as $values) { ?>
                                                <tr>
                                                    <td><?php echo $values['usu_id'] ?></td>
                                                    <td><?php echo $values['usu_nome'] ?></td>
                                                    <td><?php echo $values['usu_email'] ?></td>
                                                    <td><?php echo $values['usu_celular'] ?></td>
                                                    <td><?php echo $values['tp_nome'] ?></td>
                                                    <td>
                                                        <?php if ($values['sts_nome'] == 'Aprovado') {
                                                            echo '<span class="badge badge-pill badge-success">Aprovado</span>';
                                                        } else if ($values['sts_nome'] == 'Bloqueado') {
                                                            echo '<span class="badge badge-pill badge-dark">Bloqueado</span>';
                                                        } else if ($values['sts_nome'] == 'Reprovado') {
                                                            echo '<span class="badge badge-pill badge-danger">Reprovado</span>';
                                                        } else {
                                                            echo '<span class="badge badge-pill badge-warning">Aguardando</span>';
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <!-- Individual action buttons with tooltips -->
                                                        <button class="btn btn-sm btn-secondary visualizarUsuario" data-acao="visualizar" data-id="<?php echo $values['usu_id'] ?>" data-toggle="tooltip" data-placement="top" title="Editar">
                                                            <i class="fas fa-pen-alt"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-secondary visualizarUsuario" data-acao="resetarSenha" data-id="<?php echo $values['usu_email'] ?>" data-toggle="tooltip" data-placement="top" title="Resetar Senha">
                                                            <i class="fas fa-key"></i>
                                                        </button>
                                                        <?php if ($nivel == 1) { ?>
                                                            <button class="btn btn-sm btn-secondary visualizarUsuario" data-acao="deletar" data-id="<?php echo $values['usu_id'] ?>" data-toggle="tooltip" data-placement="top" title="Deletar Usuário">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else {
                                echo "Sem dados cadastrados";
                            } ?>
                        </div>
                    </div>
                    <div class="card-footer p-2">
                        <div class="w-100">
                            <a class='btn btn-success btn-block' href="<?php echo $baseUrl ?>cadastrar-usuario">Cadastrar Usuario <i class="fa fa-plus ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Editar Usuário -->
            <div class="modal fade" id="usuarioModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form id="formUsuEditar" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Editar Usuário</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="idEditar" name="id" />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="nomeEditar">Nome Completo</label>
                                            <input type="text" class="form-control" name="nome" id="nomeEditar" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="cpf_cnpjEditar">CPF ou CNPJ</label>
                                            <input type="text" class="form-control cpf_cnpj" id="cpf_cnpjEditar" name="cpf_cnpj" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="emailEditar">Email</label>
                                            <input type="email" class="form-control" name="email" id="emailEditar" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="celularEditar">Celular</label>
                                            <input type="text" class="form-control celular" name="celular" id="celularEditar" placeholder="(99) 9999-9999" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="dataNascimentoEditar">Data de Nascimento</label>
                                            <input type="date" class="form-control dataNascimento" id="dataNascimentoEditar" name="dataNascimento" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="sexoEditar">Sexo</label>
                                            <select class="form-control" name="sexo" id="sexoEditar" required>
                                                <option value="masculino">Masculino</option>
                                                <option value="feminino">Feminino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tipoEditar">Nível de Usuário</label>
                                            <select class="form-control" name="tipo" id="tipoEditar" required>
                                                <?php
                                                $list = selecionarDoBanco("tipo_usuario", "*", "tp_status = 1 order by tp_id desc");
                                                foreach ($list as $values) {
                                                ?>
                                                    <option value="<?php echo $values['tp_id'] ?>"><?php echo $values['tp_nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="statusEditar">Status</label>
                                            <select class="form-control" id="statusEditar" name="status" required>
                                                <?php
                                                $list = selecionarDoBanco("status", "*", "sts_status = 1");
                                                foreach ($list as $values) {
                                                ?>
                                                    <option value="<?php echo $values['sts_id'] ?>"><?php echo $values['sts_nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="senhaEditar">Senha</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="senhaEditar" name="senha">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button" onclick="toggleSenhaEditar()"><i class="far fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer p-2">
                                <input type="hidden" id="AcaoEditar" name="Acao" value="update">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(".visualizarUsuario").on("click", function(event) {
        event.preventDefault();
        var id = $(this).data("id");
        var acao = $(this).data("acao");

        if (acao === 'deletar') {
            Notiflix.Confirm.Show(
                'Confirmação',
                'Você tem certeza que deseja deletar este usuário?',
                'Sim',
                'Não',
                function() {
                    $.ajax({
                        url: '/deletar-usuario',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data.success) {
                                Notiflix.Notify.Success('Usuário deletado com sucesso!');
                                setTimeout(() => location.reload(), 2000);
                            } else {
                                Notiflix.Notify.Failure(data.msg || 'Erro ao deletar usuário.');
                            }
                        },
                        error: function() {
                            Notiflix.Notify.Failure('Erro na requisição.');
                        }
                    });
                }
            );
            return;
        } else if (acao === 'resetarSenha') {
            Notiflix.Confirm.Show(
                'Confirmação',
                'Você tem certeza que deseja resetar a senha deste usuário?',
                'Sim',
                'Não',
                function() {
                    $.ajax({
                        url: '/resetar-senha',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data.acao === 'ok') {
                                Notiflix.Notify.Success('Senha resetada com sucesso!');
                                setTimeout(() => location.reload(), 2000);
                            } else {
                                Notiflix.Notify.Failure(data.msg || 'Erro ao resetar senha.');
                            }
                        },
                        error: function() {
                            Notiflix.Notify.Failure('Erro na requisição.');
                        }
                    });
                }
            );
            return;
        } else {
            $.ajax({
                url: '/visualizar',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(data) {
                    if (data) {
                        $("#idEditar").val(data.usu_id);
                        $("#nomeEditar").val(data.usu_nome);
                        $("#cpf_cnpjEditar").val(data.usu_cpf_cnpj);
                        $("#emailEditar").val(data.usu_email);
                        $("#celularEditar").val(data.usu_celular);
                        $("#dataNascimentoEditar").val(data.usu_dataNascimento);
                        $("#sexoEditar").val(data.usu_sexo);
                        $("#statusEditar").val(data.usu_status);
                        $("#tipoEditar").val(data.usu_nivel);
                        $("#senhaEditar").val('');

                        $('#usuarioModal').modal('show');
                    } else {
                        Notiflix.Notify.Failure('Erro ao carregar usuário.');
                    }
                },
                error: function() {
                    Notiflix.Notify.Failure('Erro na requisição.');
                }
            });
            return;
        }
    });

    function toggleSenhaEditar() {
        const input = document.getElementById('senhaEditar');
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }

    $('#tipo').on('change', function() {
        var tipo = $('#tipo').val();

        if (tipo == 4) {
            $("#geracao").attr('style', 'display:block');
        } else {
            $("#geracao").attr('style', 'display:none');
            $("#geracao_id").val('0');
        }
    });

    function Dados() {
        return {
            usu_id: $('#idEditar').val(),
            usu_nome: $('#nomeEditar').val(),
            usu_cpf_cnpj: $('#cpf_cnpjEditar').val().replace('-', '').replace('.', '').replace('/', ''),
            usu_email: $('#emailEditar').val(),
            usu_celular: $('#celularEditar').val(),
            usu_dataNascimento: $('#dataNascimentoEditar').val(),
            usu_sexo: $('#sexoEditar').val(),
            usu_senha: $('#senhaEditar').val(),
            usu_nivel: $('#tipoEditar').val(),
            usu_status: $('#statusEditar').val(),
        };
    }

    // Envio do formulário de edição
    $("#formUsuEditar").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        $.ajax({
            url: '/update-adm',
            type: 'POST',
            data: {
                dados: Dados(),
                id: $('#idEditar').val(),
            },
            success: function(data) {
                Notiflix.Loading.Remove();
                if (data.success != '') {
                    Notiflix.Notify.Success('Usuário atualizado com sucesso!');
                    $('#usuarioModal').modal('hide');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    Notiflix.Notify.Failure(data.msg || 'Erro ao atualizar usuário.');
                }
            },
            error: function() {
                Notiflix.Loading.Remove();
                Notiflix.Notify.Failure('Erro na requisição.');
            }
        });
    });
</script>