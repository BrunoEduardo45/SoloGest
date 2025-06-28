<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <form id="formCliente" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Cliente</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">

                                <!-- Nome do Cliente -->
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="cli_nome">Nome</label>
                                        <input type="text" class="form-control" id="cli_nome" name="cli_nome" required>
                                    </div>
                                </div>

                                <!-- E-mail -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="cli_email">E-mail</label>
                                        <input type="email" class="form-control" id="cli_email" name="cli_email" required>
                                    </div>
                                </div>

                                <!-- Telefone -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="cli_telefone">Telefone</label>
                                        <input type="text" class="form-control" id="cli_telefone" name="cli_telefone">
                                    </div>
                                </div>

                                <!-- Endereço -->
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="cli_endereco">Endereço</label>
                                        <input type="text" class="form-control" id="cli_endereco" name="cli_endereco">
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="cli_status">Status</label>
                                        <select name="cli_status" id="cli_status" class="form-control">
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group m-0 mt-2">
                                        <button type="reset" id="limpar" name="limpar" class="btn btn-warning btn-block">Limpar<i class="fa fa-eraser ml-2"></i></button>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group m-0 mt-2">
                                        <button type="submit" id="cadastro" name="cadastro" class="btn btn-success btn-block" data-acao="salvar">Cadastrar <i class="fa fa-plus ml-2"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Clientes Cadastrados -->
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Clientes Cadastrados</h3>
                        <hr>
                        <?php
                        // Consultar os clientes cadastrados
                        $clientes = selecionarDoBanco('clientes', '*', '', [], []);
                        if (count($clientes) > 0) { ?>
                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Telefone</th>
                                            <th>Endereço</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clientes as $cliente) { ?>
                                            <tr>
                                                <td><?= $cliente['cli_id'] ?></td>
                                                <td><?= $cliente['cli_nome'] ?></td>
                                                <td><?= $cliente['cli_email'] ?></td>
                                                <td><?= $cliente['cli_telefone'] ?></td>
                                                <td><?= $cliente['cli_endereco'] ?></td>
                                                <td>
                                                    <?= $cliente['cli_status'] == '1' ? 
                                                        '<span class="badge badge-success">Ativo</span>' : 
                                                        '<span class="badge badge-danger">Inativo</span>' 
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $cliente['cli_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $cliente['cli_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhum cliente cadastrado';
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
                'cli_nome': $('#cli_nome').val(),
                'cli_email': $('#cli_email').val(),
                'cli_telefone': $('#cli_telefone').val(),
                'cli_endereco': $('#cli_endereco').val(),
                'cli_status': $('#cli_status').val()
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
                            url: '/deletar-cliente',
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
                    url: '/editar-cliente',
                    data: {
                        'id': id,
                        'acao': acao
                    },
                    type: "POST",
                    success: function(data) {
                       // Preenche o formulário com os dados do cliente
                        $('#id').val(data.cli_id);
                        $('#cli_nome').val(data.cli_nome);
                        $('#cli_email').val(data.cli_email);
                        $('#cli_telefone').val(data.cli_telefone);
                        $('#cli_endereco').val(data.cli_endereco);
                        $('#cli_status').val(data.cli_status);

                        // Muda o botão de salvar para "Atualizar"
                        $('#cadastro').attr('data-acao', 'atualizar').text('Atualizar');
                    }
                });
            }
        });

        $("#formCliente").submit(function(e) {
            e.preventDefault();
            
            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-cliente" : "/atualizar-cliente";

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