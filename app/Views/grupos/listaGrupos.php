<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <form id="formGrupo" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Grupo</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="nome">Nome do Grupo</label>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="responsavelTecnico">Responsável Técnico</label>
                                        <select name="responsavelTecnico" id="responsavelTecnico" class="form-control" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $lista = selecionarDoBanco('usuarios', '*', 'usu_nivel = 2');
                                            foreach ($lista as $values) { ?>
                                                <option value="<?= $values['usu_id'] ?>"><?= $values['usu_nome'] ?></option>
                                                ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="data">Data de inicio</label>
                                        <input type="date" class="form-control" id="data" name="data" required>
                                    </div>
                                </div>

                                <div class="form-group col-4">
                                    <label for="estado">Estado</label>
                                    <select name="estado" id="estado" class="form-control" required>
                                        <option value="">Carregando estados...</option>
                                    </select>
                                </div>

                                <div class="form-group col-4">
                                    <label for="cidade">Cidade</label>
                                    <select name="cidade" id="cidade" class="form-control" required disabled>
                                        <option value="">Selecione o estado primeiro</option>
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group mt-2">
                                        <label class="form-label" for="cadastro"></label>
                                        <button type="submit" id="cadastro" name="cadastro" class="btn btn-primary btn-block" data-acao="salvar">Cadastrar <i class="fa fa-plus ml-2"></i></button>
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
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <br>
                        <h3>Grupos Cadastrados</h3>
                        <hr>
                        <?php

                        $list = selecionarDoBanco('grupos', '*', '', [], ['inner join usuarios on usu_id = gru_responsavel_tecnico']);
                        $count = count($list);

                        if ($count > 0) { ?>

                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">ID</th>
                                            <th style="width: 20%">Nome</th>
                                            <th style="width: 25%">Responsável Técnico</th>
                                            <th style="width: 10%">Estado</th>
                                            <th style="width: 20%">Cidade</th>
                                            <th style="width: 15%">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody class="row_position">
                                        <?php foreach ($list as $values) { ?>
                                            <tr>
                                                <td><?= $values['gru_id'] ?></td>
                                                <td><?= $values['gru_nome'] ?></td>
                                                <td><?= $values['usu_nome'] ?></td>
                                                <td>
                                                    <?= $estadosIBGE[$values['gru_estado']]; ?>
                                                </td>
                                                <td><?= $values['gru_cidade'] ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $values['gru_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $values['gru_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhum grupo cadastrado';
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

        function carregarEstados() {
            $.get('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome', function(data) {
                $('#estado').empty().append('<option value="">Selecione o estado</option>');
                data.forEach(function(estado) {
                    $('#estado').append(`<option value="${estado.id}">${estado.nome}</option>`);
                });
            });
        }

        carregarEstados();

        $('#estado').on('change', function() {
            let estadoId = $(this).val();
            $('#cidade').empty().append('<option value="">Carregando cidades...</option>').prop('disabled', true);

            if (estadoId) {
                $.get(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`, function(dataCidades) {
                    $('#cidade').empty().append('<option value="">Selecione a cidade</option>').prop('disabled', false);
                    dataCidades.forEach(function(cidade) {
                        $('#cidade').append(`<option value="${cidade.nome}">${cidade.nome}</option>`);
                    });

                    if (window.cidadeEditar) {
                        $('#cidade').val(window.cidadeEditar);
                        window.cidadeEditar = null;
                    }
                });
            } else {
                $('#cidade').empty().append('<option value="">Selecione o estado primeiro</option>').prop('disabled', true);
            }
        });

        function Dados() {
            return {
                'gru_nome': $('#nome').val() ?? null,
                'gru_estado': $('#estado').val() ?? null,
                'gru_cidade': $('#cidade').val() ?? null,
                'gru_responsavel_tecnico': $('#responsavelTecnico').val() ?? null,
                'gru_data_criacao': $('#data').val()
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
                            url: '/deletar-grupo',
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
                    url: '/editar-grupo',
                    data: {
                        'id': id,
                        'acao': acao
                    },
                    type: "POST",
                    success: function(data) {
                        $("#id").val(data.gru_id);
                        $("#nome").val(data.gru_nome);
                        $("#responsavelTecnico").val(data.gru_responsavel_tecnico);
                        $("#data").val(data.gru_data_criacao);

                        window.cidadeEditar = data.gru_cidade;
                        $("#estado").val(data.gru_estado).trigger('change');

                        $("#cadastro").attr('data-acao', 'atualizar');
                        $("#cadastro").text('Atualizar');
                    }
                });
            }
        });

        $("#formGrupo").submit(function(e) {
            e.preventDefault();
            
            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-grupo" : "/atualizar-grupo";

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