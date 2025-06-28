<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <form id="formPedido" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Pedido</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">

                                <!-- Cliente -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="ped_cliente_id">Cliente</label>
                                        <select name="ped_cliente_id" id="ped_cliente_id" class="form-control" required>
                                            <option value="">Selecione o Cliente</option>
                                            <?php
                                            // Consultar os clientes cadastrados
                                            $clientes = selecionarDoBanco('clientes', '*', '', [], []);
                                            if (count($clientes) > 0) {
                                                foreach ($clientes as $cliente) {
                                                    echo '<option value="' . $cliente['cli_id'] . '">' . $cliente['cli_nome'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Produto -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="ped_produto_id">Produto</label>
                                        <select name="ped_produto_id" id="ped_produto_id" class="form-control" required>
                                            <option value="">Selecione o Produto</option>
                                            <?php
                                            // Consultar os produtos cadastrados
                                            $produtos = selecionarDoBanco('produtos', '*', '', [], []);
                                            if (count($produtos) > 0) {
                                                foreach ($produtos as $produto) {
                                                    echo '<option value="' . $produto['prod_id'] . '">' . $produto['prod_nome'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Quantidade -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="ped_quantidade">Quantidade</label>
                                        <input type="number" class="form-control" id="ped_quantidade" name="ped_quantidade" required>
                                    </div>
                                </div>

                                <!-- Valor Total -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="ped_valor_total">Valor Total</label>
                                        <input type="number" class="form-control" id="ped_valor_total" name="ped_valor_total" required>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="ped_status">Status</label>
                                        <select name="ped_status" id="ped_status" class="form-control">
                                            <option value="1">Em andamento</option>
                                            <option value="2">Finalizado</option>
                                            <option value="0">Cancelado</option>
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

            <!-- Tabela de Pedidos Cadastrados -->
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Pedidos Cadastrados</h3>
                        <hr>
                        <?php
                        // Consultar os pedidos cadastrados
                        $pedidos = selecionarDoBanco('pedidos', '*', '', [], [
                            'inner join clientes on pedidos.ped_cliente_id = clientes.cli_id',
                            'inner join produtos on pedidos.ped_produto_id = produtos.prod_id'
                        ]);
                        if (count($pedidos) > 0) { ?>
                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Valor Total</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pedidos as $pedido) { ?>
                                            <tr>
                                                <td><?= $pedido['ped_id'] ?></td>
                                                <td><?= $pedido['cli_nome'] ?></td> <!-- Aqui pode ser o nome do cliente -->
                                                <td><?= $pedido['prod_nome'] ?></td> <!-- Aqui pode ser o nome do produto -->
                                                <td><?= $pedido['ped_quantidade'] ?></td>
                                                <td><?= $pedido['ped_valor_total'] ?></td>
                                                <td>
                                                    <?= $pedido['ped_status'] == 1 ? 
                                                        '<span class="badge badge-warning">Em andamento</span>' : 
                                                        ($pedido['ped_status'] == 2 ? 
                                                        '<span class="badge badge-success">Finalizado</span>' :
                                                        '<span class="badge badge-danger">Cancelado</span>')
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $pedido['ped_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $pedido['ped_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhum pedido cadastrado';
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
                'ped_cliente_id': $('#ped_cliente_id').val(),
                'ped_produto_id': $('#ped_produto_id').val(),
                'ped_quantidade': $('#ped_quantidade').val(),
                'ped_valor_total': $('#ped_valor_total').val(),
                'ped_status': $('#ped_status').val(),
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
                            url: '/deletar-pedido',
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
                    url: '/editar-pedido',
                    data: {
                        'id': id,
                        'acao': acao
                    },
                    type: "POST",
                    success: function(data) {
                        $('#id').val(data.ped_id);
                        $('#ped_cliente_id').val(data.ped_cliente_id);
                        $('#ped_produto_id').val(data.ped_produto_id);
                        $('#ped_quantidade').val(data.ped_quantidade);
                        $('#ped_valor_total').val(data.ped_valor_total);
                        $('#ped_status').val(data.ped_status);

                        $("#cadastro").attr('data-acao', 'atualizar');
                        $("#cadastro").text('Atualizar');
                    }
                });
            }
        });

        $("#formPedido").submit(function(e) {
            e.preventDefault();
            
            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-pedido" : "/atualizar-pedido";

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