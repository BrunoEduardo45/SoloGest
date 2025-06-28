<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <form id="formCultivo" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Tipos de Cultivo</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">

                                <!-- Nome do Cultivo -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="cultivo_nome">Nome do Cultivo</label>
                                        <input type="text" class="form-control" id="cultivo_nome" name="cultivo_nome" required>
                                    </div>
                                </div>

                                <!-- Tipo de Cultivo -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="cultivo_tipo">Tipo de Cultivo</label>
                                        <select name="cultivo_tipo" id="cultivo_tipo" class="form-control">
                                            <option value="Anual">Anual</option>
                                            <option value="Perene">Perene</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Descrição do Cultivo -->
                                <div class="col-lg-12">
                                    <div class="form-group mb-0">
                                        <label for="cultivo_descricao">Descrição</label>
                                        <textarea class="form-control" id="cultivo_descricao" name="cultivo_descricao"></textarea>
                                    </div>
                                </div>

                                <div class="col-12 justify-content-end d-flex p-0">
                                    <div class="col-lg-3">
                                        <div class="form-group mb-0">
                                            <label class="form-label" for="cadastro"></label>
                                            <button type="submit" id="cadastro" name="cadastro" class="btn btn-success btn-block" data-acao="salvar">Cadastrar <i class="fa fa-plus ml-2"></i></button>
                                        </div>
                                    </div>
    
                                    <div class="col-lg-3">
                                        <div class="form-group mb-0">
                                            <label class="form-label" for="limpar"></label>
                                            <button type="reset" id="limpar" name="limpar" class="btn btn-warning btn-block">Limpar<i class="fa fa-eraser ml-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Tipos de Cultivos Cadastrados -->
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Tipos de Cultivo Cadastrados</h3>
                        <hr>
                        <?php
                        // Consultar os cultivos cadastrados
                        $cultivos = selecionarDoBanco('cultivos');
                        if (count($cultivos) > 0) { ?>
                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Descrição</th>
                                            <th>Tipo</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cultivos as $cultivo) { ?>
                                            <tr>
                                                <td><?= $cultivo['cul_id'] ?></td>
                                                <td><?= $cultivo['cul_nome'] ?></td>
                                                <td><?= $cultivo['cul_descricao'] ?></td>
                                                <td><?= $cultivo['cul_tipo'] ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $cultivo['cul_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $cultivo['cul_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhum tipo de cultivo cadastrado';
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
            'cul_nome': $('#cultivo_nome').val(),
            'cul_descricao': $('#cultivo_descricao').val(),
            'cul_tipo': $('#cultivo_tipo').val()
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
                        url: '/deletar-cultivo',
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
                url: '/editar-cultivo',
                data: { 'id': id, 'acao': acao },
                type: "POST",
                success: function(data) {
                    $("#id").val(data.cul_id);
                    $("#cultivo_nome").val(data.cul_nome);
                    $("#cultivo_descricao").val(data.cul_descricao);
                    $("#cultivo_tipo").val(data.cul_tipo);

                    $("#cadastro").attr('data-acao', 'atualizar');
                    $("#cadastro").text('Atualizar');
                }
            });
        }
    });

    // Envio do formulário
    $("#formCultivo").submit(function(e) {
        e.preventDefault();

        Notiflix.Loading.Pulse('Carregando...');
        var acao = $('#cadastro').data('acao');
        var url = acao === "salvar" ? "/cadastrar-cultivo" : "/atualizar-cultivo";

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