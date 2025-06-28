<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <form id="formCompra" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Requisição de Compra</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">

                                <!-- Produto -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="comp_produto_id">Produto</label>
                                        <select name="comp_produto_id" id="comp_produto_id" class="form-control" required>
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
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="comp_quantidade">Quantidade</label>
                                        <input type="number" class="form-control" id="comp_quantidade" name="comp_quantidade" required>
                                    </div>
                                </div>

                                <!-- Valor Total -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="comp_valor_total">Valor Total</label>
                                        <input type="number" class="form-control" id="comp_valor_total" name="comp_valor_total" required>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="comp_status">Status</label>
                                        <select name="comp_status" id="comp_status" class="form-control">
                                            <option value="1">Pendente</option>
                                            <option value="2">Aprovado</option>
                                            <option value="0">Rejeitado</option>
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

            <!-- Tabela de Requisições de Compras Cadastradas -->
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Requisições de Compras Cadastradas</h3>
                        <hr>
                        <?php
                        // Consultar as requisições de compras cadastradas
                        $requisicoes = selecionarDoBanco('compras', '*', '', [], []);
                        if (count($requisicoes) > 0) { ?>
                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Valor Total</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requisicoes as $requisicao) { ?>
                                            <tr>
                                                <td><?= $requisicao['comp_id'] ?></td>
                                                <td><?= $requisicao['comp_produto_id'] ?></td> <!-- Aqui pode ser o nome do produto -->
                                                <td><?= $requisicao['comp_quantidade'] ?></td>
                                                <td><?= $requisicao['comp_valor_total'] ?></td>
                                                <td>
                                                    <?= $requisicao['comp_status'] == 1 ? 
                                                        '<span class="badge badge-warning">Pendente</span>' : 
                                                        ($requisicao['comp_status'] == 2 ? 
                                                        '<span class="badge badge-success">Aprovado</span>' :
                                                        '<span class="badge badge-danger">Rejeitado</span>')
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $requisicao['comp_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $requisicao['comp_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhuma requisição de compra cadastrada';
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
                'comp_produto_id': $('#comp_produto_id').val(),
                'comp_quantidade': $('#comp_quantidade').val(),
                'comp_valor_total': $('#comp_valor_total').val(),
                'comp_status': $('#comp_status').val()
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
                            url: '/deletar-compra',
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
                    url: '/editar-compra',
                    data: {
                        'id': id,
                        'acao': acao
                    },
                    type: "POST",
                    success: function(data) {
                        $('#id').val(data.comp_id);
                        $('#comp_produto_id').val(data.comp_produto_id);
                        $('#comp_quantidade').val(data.comp_quantidade);
                        $('#comp_valor_total').val(data.comp_valor_total);
                        $('#comp_status').val(data.comp_status);

                        $("#cadastro").attr('data-acao', 'atualizar');
                        $("#cadastro").text('Atualizar');
                    }
                });
            }
        });

        $("#formCompra").submit(function(e) {
            e.preventDefault();
            
            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-compra" : "/atualizar-compra";

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