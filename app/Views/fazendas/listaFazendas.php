<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <form id="formFazenda" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Fazenda</h3>
                            <hr>
                            <div class="row">
                                <input type="hidden" id="id" name="id">

                                <!-- Nome da Fazenda -->
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="faz_nome">Nome da Fazenda</label>
                                        <input type="text" class="form-control" id="faz_nome" name="faz_nome" required>
                                    </div>
                                </div>

                                <!-- Responsável Técnico -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="faz_responsavel_tecnico">Responsável Técnico</label>
                                        <select name="faz_responsavel_tecnico" id="faz_responsavel_tecnico" class="form-control" required>
                                            <option value="">Selecione o Responsável</option>
                                            <?php
                                            // Consultar os responsáveis técnicos cadastrados
                                            $responsaveis = selecionarDoBanco('responsaveis', '*', 'res_status = 1', [], []);
                                            if (count($responsaveis) > 0) {
                                                foreach ($responsaveis as $responsavel) {
                                                    echo '<option value="' . $responsavel['res_id'] . '">' . $responsavel['res_nome'] . '</option>';
                                                }
                                            } 
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Área Total -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="faz_area_total">Área Total (hectares)</label>
                                        <input type="number" class="form-control" id="faz_area_total" name="faz_area_total" required>
                                    </div>
                                </div>

                                <!-- Ano de Início -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="faz_ano_inicio">Ano de Início</label>
                                        <input type="number" class="form-control" id="faz_ano_inicio" name="faz_ano_inicio">
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="faz_status">Status</label>
                                        <select name="faz_status" id="faz_status" class="form-control">
                                            <option value="1">Ativa</option>
                                            <option value="0">Inativa</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="form-group col-lg-4">
                                    <label for="faz_estado">Estado</label>
                                    <select name="faz_estado" id="faz_estado" class="form-control" required>
                                        <option value="">Carregando estados...</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="faz_cidade">Cidade</label>
                                    <select name="faz_cidade" id="faz_cidade" class="form-control" required disabled>
                                        <option value="">Selecione o estado primeiro</option>
                                    </select>
                                </div>

                                <!-- Complemento -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="faz_complemento">Complemento</label>
                                        <input type="text" class="form-control" id="faz_complemento" name="faz_complemento">
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

            <!-- Tabela de Fazendas Cadastradas -->
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <h3>Fazendas Cadastradas</h3>
                        <hr>
                        <?php
                        // Consultar as fazendas cadastradas
                        $fazendas = selecionarDoBanco('fazendas', '*', '', [], []);
                        if (count($fazendas) > 0) { ?>
                            <div class="table-responsive">
                                <table id="table" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Responsável Técnico</th>
                                            <th>Área Total</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($fazendas as $fazenda) { ?>
                                            <tr>
                                                <td><?= $fazenda['faz_id'] ?></td>
                                                <td><?= $fazenda['faz_nome'] ?></td>
                                                <td><?= $fazenda['faz_responsavel_tecnico'] ?></td>
                                                <td><?= $fazenda['faz_area_total'] ?> ha</td>
                                                <td>
                                                    <?= $fazenda['faz_status'] == '1' ? 
                                                        '<span class="badge badge-success">Ativa</span>' : 
                                                        '<span class="badge badge-danger">Inativa</span>' 
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary editarBtn" data-id="<?= $fazenda['faz_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></button>
                                                    <button class="btn btn-sm btn-danger editarBtn" data-id="<?= $fazenda['faz_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo 'Nenhuma fazenda cadastrada';
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
                $('#faz_estado').empty().append('<option value="">Selecione o estado</option>');
                data.forEach(function(estado) {
                    $('#faz_estado').append(`<option value="${estado.id}">${estado.nome}</option>`);
                });
            });
        }

        carregarEstados();

        $('#faz_estado').on('change', function() {
            let estadoId = $(this).val();
            $('#faz_cidade').empty().append('<option value="">Carregando cidades...</option>').prop('disabled', true);

            if (estadoId) {
                $.get(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`, function(dataCidades) {
                    $('#faz_cidade').empty().append('<option value="">Selecione a cidade</option>').prop('disabled', false);
                    dataCidades.forEach(function(cidade) {
                        $('#faz_cidade').append(`<option value="${cidade.nome}">${cidade.nome}</option>`);
                    });

                    if (window.cidadeEditar) {
                        $('#faz_cidade').val(window.cidadeEditar);
                        window.cidadeEditar = null;
                    }
                });
            } else {
                $('#faz_cidade').empty().append('<option value="">Selecione o estado primeiro</option>').prop('disabled', true);
            }
        });

        function Dados() {
            return {
                'faz_nome': $('#faz_nome').val(),
                'faz_responsavel_tecnico': $('#faz_responsavel_tecnico').val(),
                'faz_area_total': $('#faz_area_total').val(),
                'faz_ano_inicio': $('#faz_ano_inicio').val(),
                'faz_status': $('#faz_status').val(),
                'faz_estado': $('#faz_estado').val(),
                'faz_cidade': $('#faz_cidade').val(),
                'faz_complemento': $('#faz_complemento').val()
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
                            url: '/deletar-fazenda',
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
                    url: '/editar-fazenda',
                    data: { 'id': id, 'acao': acao },
                    type: "POST",
                    success: function(data) {
                        // Preenche o formulário com os dados da fazenda
                        $('#id').val(data.faz_id);
                        $('#faz_nome').val(data.faz_nome);
                        $('#faz_responsavel_tecnico').val(data.faz_responsavel_tecnico);
                        $('#faz_area_total').val(data.faz_area_total);
                        $('#faz_localizacao').val(data.faz_localizacao);
                        $('#faz_ano_inicio').val(data.faz_ano_inicio);
                        $('#faz_status').val(data.faz_status);
                        $('#faz_estado').val(data.faz_estado);  // Estado da fazenda
                        $('#faz_cidade').val(data.faz_cidade);  // Cidade da fazenda
                        $('#faz_complemento').val(data.faz_complemento);  // Complemento da fazenda

                        // Atualiza o estado, e após a mudança de estado, carrega a cidade correta
                        window.cidadeEditar = data.faz_cidade;
                        $("#faz_estado").val(data.faz_estado).trigger('change');

                        // Muda o botão de salvar para "Atualizar"
                        $('#cadastro').attr('data-acao', 'atualizar').text('Atualizar');
                    }
                });
            }
        });

        // Enviar formulário
        $("#formFazenda").submit(function(e) {
            e.preventDefault();

            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-fazenda" : "/atualizar-fazenda";

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
