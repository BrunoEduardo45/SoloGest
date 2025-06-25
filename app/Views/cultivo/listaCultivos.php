<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <form id="formCultivo" method="post">
                        <div class="card-body">
                            <h3>Cadastro de tipos de cultivos</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="exemplo">Exemplo</label>
                                        <input type="text" class="form-control" id="exemplo" name="exemplo" required>
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
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <br>
                        <h3>Tipos de cultivos cadastrados</h3>
                        <hr>
                        <?php

                        // $list = selecionarDoBanco('grupos', '*', '', [], ['inner join usuarios on usu_id = gru_responsavel_tecnico']);
                        // $count = count($list);

                        $count = '';
                        $list = [];

                        if ($count > 0) { ?>

                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">ID</th>
                                            <th style="width: 70%">Exemplo</th>
                                            <th style="width: 20%">Exemplo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="row_position">
                                        <?php foreach ($list as $values) { ?>
                                            <tr>
                                                <td><?= $values['id'] ?></td>
                                                <td><?= $values['exemplo'] ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $values['id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $values['id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhum cultivo cadastrado';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {

        function Dados() {
            return {
                'ped_exemplo': $('#exemplo').val() ?? null,
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
                            url: '/deletar-cultivo',
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
                    url: '/editar-cultivo',
                    data: {
                        'id': id,
                        'acao': acao
                    },
                    type: "POST",
                    success: function(data) {
                        $("#id").val(data.id);
                        $("#exemplo").val(data.exemplo);

                        $("#cadastro").attr('data-acao', 'atualizar');
                        $("#cadastro").text('Atualizar');
                    }
                });
            }
        });

        $("#formCultivo").submit(function(e) {
            e.preventDefault();
            
            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-cultivo" : "/atualizar-cultivo";

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    dados: Dados()
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

    });
</script>