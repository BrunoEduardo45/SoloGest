<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Cadastrar Tipo de Usuário</h3>
                        <hr>
                        <div class="col-md-12">
                            <form id="form" method="post">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="" />
                                    <div class="col-lg-6">
                                        <div id="step01" class="form-group">
                                            <label class="form-label" for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="1">Ativo</option>
                                                <option value="0">Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group mt-2">
                                            <label class="form-label" for="cadastro"></label>
                                            <button type="submit" id="cadastro" name="cadastro" class="btn btn-success btn-block" data-acao="salvar">Cadastrar <i class="fa fa-plus ml-2"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group mt-2">
                                            <label class="form-label" for="limpar"></label>
                                            <button type="reset" id="limpar" name="limpar" class="btn btn-warning btn-block">Limpar<i class="fa fa-eraser ml-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Tipos de Usuários Cadastrados</h3>
                        <hr>
                        <?php

                        $list = selecionarDoBanco('tipo_usuario');
                        $count = count($list);

                        if ($count > 0) { ?>

                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">ID</th>
                                            <th style="width: 70%">Nome</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 10%">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody class="row_position">

                                        <?php foreach ($list as $values) { ?>
                                            <tr>
                                                <td><?php echo $values['tp_id'] ?></td>
                                                <td><?php echo $values['tp_nome'] ?></td>
                                                <td><?= ($values['tp_status'] == 1) ? '<span class="badge badge-pill badge-success">Ativo</span>' : '<span class="badge badge-pill badge-danger">Inativo</span>'; ?></td>
                                                <td>
                                                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                                                        <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['tp_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></a>
                                                        <?php if ($nivel == 1) { ?>
                                                            <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['tp_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhum tipo de usuário cadastrado';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function Dados() {
        return {
            'tp_nome': $('#nome').val() ?? null,
            'tp_status': $('#status').val() ?? null,
        };
    }

    $('.editarBtn').click(function() {
        event.preventDefault();
        var id = $(this).data('id');
        var acao = $(this).data('acao');

        if (acao == 'deletar') {
            Notiflix.Confirm.Show(
                'Deletar!',
                'Tem certeza que deseja deletar?',
                'Sim',
                'Não',
                function okCb() {
                    Notiflix.Loading.Pulse('Carregando...');
                    $.ajax({
                        url: '/deletar-tipousuario',
                        data: {
                            'id': id,
                            'acao': acao
                        },
                        type: "POST",
                        success: function(data) {
                            location.reload();
                        }
                    });
                }
            );
        } else {
            $.ajax({
                url: '/editar-tipousuario',
                data: {
                    'id': $(this).data('id'),
                    'acao': $(this).data('acao')
                },
                type: "POST",
                success: function(data) {
                    if (data.acao == 'editar') {
                        $("#id").val(data.id);
                        $("#nome").val(data.nome);
                        $("#status").val(data.status);
                        $("#cadastro").attr('data-acao', 'atualizar');
                        $("#cadastro").text('Atualizar');
                    } else {
                        location.reload();
                    }

                }
            });
        }
    });

    $("#form").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');
        var acao = $('#cadastro').data('acao');

        if (acao == "salvar") {
            var url = "/cadastrar-tipousuario"
        } else {
            var url = "/atualizar-tipousuario"
        }

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id': $("#id").val(),
                'dados': Dados()
            },
            success: function(data) {
                if (data.success != '' && acao == "salvar") {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success('Cadastrado com Sucesso!');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else if (data.success != '' && acao != "salvar") {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success('Atualizada com Sucesso!');
                    setTimeout(function() {
                        location.reload();
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