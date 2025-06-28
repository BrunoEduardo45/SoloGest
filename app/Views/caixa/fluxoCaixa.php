<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <!-- Cadastro de Fluxo de Caixa -->
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <form id="formFluxoCaixa" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Fluxo de Caixa</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">

                                <!-- Data -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="caixa_data">Data</label>
                                        <input type="date" class="form-control" id="caixa_data" name="caixa_data" required>
                                    </div>
                                </div>

                                <!-- Descrição -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="caixa_descricao">Descrição</label>
                                        <input type="text" class="form-control" id="caixa_descricao" name="caixa_descricao" required>
                                    </div>
                                </div>

                                <!-- Valor -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="caixa_valor">Valor</label>
                                        <input type="number" class="form-control" id="caixa_valor" name="caixa_valor" required>
                                    </div>
                                </div>

                                <!-- Tipo -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="caixa_tipo">Tipo</label>
                                        <select name="caixa_tipo" id="caixa_tipo" class="form-control" required>
                                            <option value="entrada">Entrada</option>
                                            <option value="saida">Saída</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Categoria -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="caixa_categoria">Categoria</label>
                                        <input type="text" class="form-control" id="caixa_categoria" name="caixa_categoria">
                                    </div>
                                </div>

                                <!-- Forma de Pagamento -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="caixa_forma_pagamento">Forma de Pagamento</label>
                                        <input type="text" class="form-control" id="caixa_forma_pagamento" name="caixa_forma_pagamento">
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="caixa_status">Status</label>
                                        <select name="caixa_status" id="caixa_status" class="form-control">
                                            <option value="pendente">Pendente</option>
                                            <option value="confirmado">Confirmado</option>
                                            <option value="cancelado">Cancelado</option>
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

            <!-- Tabela de fluxo de Caixa Cadastrado -->
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Fluxo de Caixa Cadastrado</h3>
                        <hr>
                        <?php
                        // Consultar os caixas de caixa cadastrados
                        $caixas = selecionarDoBanco('caixa');
                        if (count($caixas) > 0) { ?>
                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Data</th>
                                            <th>Descrição</th>
                                            <th>Valor</th>
                                            <th>Tipo</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($caixas as $caixa) { ?>
                                            <tr>
                                                <td><?= $caixa['caixa_id'] ?></td>
                                                <td><?= $caixa['caixa_data'] ?></td>
                                                <td><?= $caixa['caixa_descricao'] ?></td>
                                                <td><?= number_format($caixa['caixa_valor'], 2, ',', '.') ?></td>
                                                <td><?= $caixa['caixa_tipo'] == 'entrada' ? 'Entrada' : 'Saída' ?></td>
                                                <td><?= $caixa['caixa_status'] == 'pendente' ? 
                                                    '<span class="badge badge-warning">Pendente</span>' : 
                                                    ($caixa['caixa_status'] == 'confirmado' ? 
                                                    '<span class="badge badge-success">Confirmado</span>' :
                                                    '<span class="badge badge-danger">Cancelado</span>') 
                                                ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $caixa['caixa_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $caixa['caixa_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhum fluxo de caixa cadastrado';
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
                'caixa_data': $('#caixa_data').val(),
                'caixa_descricao': $('#caixa_descricao').val(),
                'caixa_valor': $('#caixa_valor').val(),
                'caixa_tipo': $('#caixa_tipo').val(),
                'caixa_categoria': $('#caixa_categoria').val(),
                'caixa_forma_pagamento': $('#caixa_forma_pagamento').val(),
                'caixa_status': $('#caixa_status').val(),
                'caixa_usuario_id': <?= $usuId ?>
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
                            url: '/deletar-caixa',
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
                    url: '/editar-caixa',
                    data: { 'id': id, 'acao': acao },
                    type: "POST",
                    success: function(data) {
                        $('#id').val(data.caixa_id);
                        $('#caixa_data').val(data.caixa_data);
                        $('#caixa_descricao').val(data.caixa_descricao);
                        $('#caixa_valor').val(data.caixa_valor);
                        $('#caixa_tipo').val(data.caixa_tipo);
                        $('#caixa_categoria').val(data.caixa_categoria);
                        $('#caixa_forma_pagamento').val(data.caixa_forma_pagamento);
                        $('#caixa_status').val(data.caixa_status);

                        $("#cadastro").attr('data-acao', 'atualizar');
                        $("#cadastro").text('Atualizar');
                    }
                });
            }
        });

        $("#formFluxoCaixa").submit(function(e) {
            e.preventDefault();

            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-caixa" : "/atualizar-caixa";

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
