<?php

    $grupos = selecionarDoBanco('grupos', 'gru_id, gru_nome', '', []);
    $produtores = selecionarDoBanco(
        'usuarios', '*', 'usu_nivel = ' . 3, [],
        [
            'left join produtor on prod_usu_id = usu_id',
            'left join grupos on gru_id = prod_grupo_id',
        ]
    );

?>

<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <form id="formProducao" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Produção de Cacau</h3>
                            <hr>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="grupo">Grupo</label>
                                        <select name="grupo" id="grupo" class="form-control" onchange="BuscarProdutores()" required>
                                            <option value="">Selecione o Grupo</option>
                                            <?php foreach ($grupos as $grupo) { ?>
                                                <option value="<?php echo $grupo['gru_id']; ?>"><?php echo $grupo['gru_nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="produtor">Produtor</label>
                                        <select name="produtor" id="produtor" class="form-control" required>
                                            <option value="">Selecione o Produtor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="ano">Ano da Produção</label>
                                        <input type="number" class="form-control" id="ano" name="ano" required min="2000" max="2100">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="tipo_clone">Tipo de Clone</label>
                                        <input type="text" class="form-control" id="tipo_clone" name="tipo_clone" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="area_produzida">Área Produzida (hectares)</label>
                                        <input type="number" class="form-control" id="area_produzida" name="area_produzida" required step="0.01">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="volume_produzido">Volume Produzido (Kg)</label>
                                        <input type="number" class="form-control" id="volume_produzido" name="volume_produzido" required step="0.01">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="data_inicio">Data de Início da Produção</label>
                                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="data_fim">Data de Fim da Produção</label>
                                        <input type="date" class="form-control" id="data_fim" name="data_fim" required>
                                    </div>
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

            <!-- Seleção de Grupo para Mostrar Produtores -->
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3>Lista de Produtores do Grupo</h3>
                        <div class="col-lg-12 p-0 ">
                            <div class="form-group mt-4">
                                <select name="grupoprodutores" id="grupoprodutores" class="form-control" required>
                                    <option value="">Selecione o Grupo</option>
                                    <?php
                                    $grupos = selecionarDoBanco('grupos', 'gru_id, gru_nome', '', []);
                                    foreach ($grupos as $grupo) { ?>
                                        <option value="<?php echo $grupo['gru_id']; ?>"><?php echo $grupo['gru_nome']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="produtoresList"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>

    function Dados() {
        return {
            producao_grupo_id: $('#grupo').val(),
            producao_produtor_id: $('#produtor').val(),
            producao_ano: $('#ano').val(),
            producao_tipo_clone: $('#tipo_clone').val(),
            producao_area_produzida: $('#area_produzida').val(),
            producao_volume_produzido: $('#volume_produzido').val(),
            producao_data_inicio: $('#data_inicio').val(),
            producao_data_fim: $('#data_fim').val()
        };
    }

    function BuscarProdutores() {

        var grupoId = $('#grupo').val();

        if (!grupoId) {
            $('#produtor').html('<option value="">Selecione o Produtor</option>');
            return;
        }
        
        var produtores = <?php echo json_encode($produtores); ?>;
        var filteredProdutores = produtores.filter(function(produtor) {
            return produtor.gru_id == grupoId; 
        });

        var options = '<option value="">Selecione o Produtor</option>';
        filteredProdutores.forEach(function(produtor) {
            options += `<option value="${produtor.usu_id}">${produtor.usu_nome}</option>`;
        });

        $('#produtor').html(options);
    };

    $('#grupoprodutores').on('change', function() {
        let grupoId = $(this).val();

        if (!grupoId) {
            $('#produtoresList').html(''); 
            return;
        } else {
            $.ajax({
                type: "POST",
                url: "/listar-producaodogrupo",
                data: {
                    'grupo_id': grupoId
                },
                dataType: "json",
                success: function(data) {

                    var html = '';
                    if (data != '' && data.length > 0) {
                        html += '<table id="table" class="table table-hover table-sm w-100">';
                        html += '<thead><tr><th class="text-left">ID</th><th>Nome</th><th class="text-left">Tipo de Clone</th><th class="text-left">Área Produzida</th><th class="text-left">Volume Produzido</th></tr></thead><tbody>';
                        data.forEach(function(produtor) {
                            html += `<tr>
                                <td class="text-left">${produtor.usu_id}</td>
                                <td class="text-left">${produtor.usu_nome}</td>
                                <td class="text-left">${produtor.producao_tipo_clone || 'Não Informado'}</td>
                                <td class="text-left">${produtor.producao_area_produzida || 'Não Informado'}</td>
                                <td class="text-left">${produtor.producao_volume_produzido || 'Não Informado'}</td>
                            </tr>`;
                        });
                        html += '</tbody></table>';
                    } else {
                        html = '<p class="w-100 text-center mt-4 mb-2">Nenhum produtor encontrado para este grupo.</p>';
                    }
                    $('#produtoresList').html(html);
                    $('#table').DataTable({
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
                        }
                    });
                },
                error: function(error) {
                    console.error("Erro na requisição AJAX:", error);
                }
            });
        }
    });

    $("#formProducao").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        $.ajax({
            type: "POST",
            url: "/cadastrar-producao",
            data: {
                dados: Dados()
            },
            success: function(data) {
                Notiflix.Loading.Remove();
                if (data.success != "") {
                    Notiflix.Notify.Success('Produção cadastrada com sucesso!');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Notiflix.Notify.Failure(data.msg);
                }
            },
            error: function(error) {
                console.error("Erro na requisição AJAX:", error);
            }
        });
    });

</script>