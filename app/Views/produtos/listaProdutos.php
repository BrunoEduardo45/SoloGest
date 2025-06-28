<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <form id="formProduto" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Produto e Insumo</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">

                                <!-- Nome do Produto -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="produto_nome">Nome do Produto</label>
                                        <input type="text" class="form-control" id="produto_nome" name="produto_nome" required>
                                    </div>
                                </div>

                                <!-- Categoria -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="produto_categoria">Categoria</label>
                                        <input type="text" class="form-control" id="produto_categoria" name="produto_categoria" required>
                                    </div>
                                </div>

                                <!-- Quantidade -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="produto_quantidade">Quantidade</label>
                                        <input type="number" class="form-control" id="produto_quantidade" name="produto_quantidade" required>
                                    </div>
                                </div>

                                <!-- Preço -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="produto_preco">Preço</label>
                                        <input type="number" class="form-control" id="produto_preco" name="produto_preco" step="0.01" required>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="produto_status">Status</label>
                                        <select name="produto_status" id="produto_status" class="form-control">
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Complemento -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="produto_complemento">Complemento</label>
                                        <input type="text" class="form-control" id="produto_complemento" name="produto_complemento">
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

            <!-- Tabela de Produtos Cadastrados -->
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Produtos Cadastrados</h3>
                        <hr>
                        <?php
                        // Consultar os produtos cadastrados
                        $produtos = selecionarDoBanco('produtos', '*', '', [], []);
                        if (count($produtos) > 0) { ?>
                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Categoria</th>
                                            <th>Quantidade</th>
                                            <th>Preço</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($produtos as $produto) { ?>
                                            <tr>
                                                <td><?= $produto['prod_id'] ?></td>
                                                <td><?= $produto['prod_nome'] ?></td>
                                                <td><?= $produto['prod_categoria'] ?></td>
                                                <td><?= $produto['prod_quantidade'] ?></td>
                                                <td><?= number_format($produto['prod_preco'], 2, ',', '.') ?></td>
                                                <td>
                                                    <?= $produto['prod_status'] == 1 ? 
                                                        '<span class="badge badge-success">Ativo</span>' : 
                                                        '<span class="badge badge-danger">Inativo</span>' 
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $produto['prod_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $produto['prod_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhum produto cadastrado';
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
                'prod_nome': $('#produto_nome').val(),
                'prod_categoria': $('#produto_categoria').val(),
                'prod_quantidade': $('#produto_quantidade').val(),
                'prod_preco': $('#produto_preco').val(),
                'prod_status': $('#produto_status').val(),
                'prod_complemento': $('#produto_complemento').val()
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
                            url: '/deletar-produto',
                            data: { 'id': id, 'acao': acao },
                            type: "POST",
                            success: function(data) {
                                location.reload();
                            }
                        });
                    }
                );
            } else {
                $.ajax({
                    url: '/editar-produto',
                    data: { 'id': id, 'acao': acao },
                    type: "POST",
                    success: function(data) {
                        // Preenche o formulário com os dados do produto
                        $('#id').val(data.prod_id);
                        $('#produto_nome').val(data.prod_nome);
                        $('#produto_categoria').val(data.prod_categoria);
                        $('#produto_quantidade').val(data.prod_quantidade);
                        $('#produto_preco').val(data.prod_preco);
                        $('#produto_complemento').val(data.prod_complemento);
                        $('#produto_status').val(data.prod_status);

                        // Muda o botão de salvar para "Atualizar"
                        $('#cadastro').attr('data-acao', 'atualizar').text('Atualizar');
                    }
                });
            }
        });

        $("#formProduto").submit(function(e) {
            e.preventDefault();

            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-produto" : "/atualizar-produto";

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
                        Notiflix.Notify.Success('Produto cadastrado com sucesso!');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else if (data.success != '' && acao != "salvar") {
                        Notiflix.Loading.Remove();
                        Notiflix.Notify.Success('Produto atualizado com sucesso!');
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