<?php
$responsaveis = selecionarDoBanco('responsaveis');
?>

<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <form id="formResponsavel" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Responsável Técnico</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">

                                <!-- Nome do Responsável -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="res_nome">Nome</label>
                                        <input type="text" class="form-control" id="res_nome" name="res_nome" required>
                                    </div>
                                </div>

                                <!-- E-mail -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="res_email">E-mail</label>
                                        <input type="email" class="form-control" id="res_email" name="res_email">
                                    </div>
                                </div>

                                <!-- Telefone -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="res_telefone">Telefone</label>
                                        <input type="text" class="form-control" id="res_telefone" name="res_telefone">
                                    </div>
                                </div>

                                <!-- Cargo -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="res_cargo">Cargo</label>
                                        <input type="text" class="form-control" id="res_cargo" name="res_cargo">
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="res_status">Status</label>
                                        <select name="res_status" id="res_status" class="form-control">
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
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Responsáveis Cadastrados -->
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Responsáveis Cadastrados</h3>
                        <hr>
                        <?php
                        // Verificar se há dados
                        if (count($responsaveis) > 0) { ?>
                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Telefone</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($responsaveis as $responsavel) { ?>
                                            <tr>
                                                <td><?= $responsavel['res_id'] ?></td>
                                                <td><?= $responsavel['res_nome'] ?></td>
                                                <td><?= $responsavel['res_telefone'] ?></td>
                                                <td>
                                                    <?= $responsavel['res_status'] == 1 ? 
                                                        '<span class="badge badge-success">Ativo</span>' : 
                                                        '<span class="badge badge-danger">Inativo</span>' 
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $responsavel['res_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $responsavel['res_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhum responsável cadastrado';
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
                'res_nome': $('#res_nome').val(),
                'res_email': $('#res_email').val(),
                'res_telefone': $('#res_telefone').val(),
                'res_cargo': $('#res_cargo').val(),
                'res_status': $('#res_status').val()
            };
        }

        // Função para editar
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
                            url: '/deletar-responsaveis',
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
                    url: '/editar-responsaveis',
                    data: {
                        'id': id,
                        'acao': acao
                    },
                    type: "POST",
                    success: function(data) {
                        $("#id").val(data.res_id);
                        $("#res_nome").val(data.res_nome);
                        $("#res_email").val(data.res_email);
                        $("#res_telefone").val(data.res_telefone);
                        $("#res_cargo").val(data.res_cargo);
                        $("#res_status").val(data.res_status);

                        $("#cadastro").attr('data-acao', 'atualizar');
                        $("#cadastro").text('Atualizar');
                    }
                });
            }
        });

        // Envio do formulário
        $("#formResponsavel").submit(function(e) {
            e.preventDefault();

            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-responsaveis" : "/atualizar-responsaveis";

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: $('#id').val(),
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
                        Notiflix.Notify.Success('Atualizado com Sucesso!');
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