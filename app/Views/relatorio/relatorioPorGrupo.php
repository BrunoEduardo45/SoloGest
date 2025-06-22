<?php
    // Dados fictícios para ilustrar
    $grupos = [
        ['gru_id' => 1, 'gru_nome' => 'Grupo A'],
        ['gru_id' => 2, 'gru_nome' => 'Grupo B'],
        ['gru_id' => 3, 'gru_nome' => 'Grupo C']
    ];

    // Filtro de data
    $dataInicial = isset($_GET['dataInicial']) ? $_GET['dataInicial'] : "";
    $dataFinal = isset($_GET['dataFinal']) ? $_GET['dataFinal'] : "";
    $grupoId = isset($_GET['grupoId']) ? $_GET['grupoId'] : "";

    // Dados fictícios de produtores
    $produtores = [
        ['producao_produtor_id' => 1, 'usu_nome' => 'Produtor 1', 'area_total' => 120.5, 'volume_total' => 2500],
        ['producao_produtor_id' => 2, 'usu_nome' => 'Produtor 2', 'area_total' => 90.3, 'volume_total' => 1800],
        ['producao_produtor_id' => 3, 'usu_nome' => 'Produtor 3', 'area_total' => 200.0, 'volume_total' => 3500]
    ];
?>

<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            
            <!-- Pesquisa de filtro -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <h3>Consulta de Relatório por Grupo</h3>
                            <hr>
                            <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="grupo">Grupo</label>
                                            <select name="grupoId" id="grupo" class="form-control">
                                                <option value="">Selecione o Grupo</option>
                                                <?php foreach ($grupos as $grupo) { ?>
                                                    <option value="<?php echo $grupo['gru_id']; ?>" <?php echo ($grupo['gru_id'] == $grupoId) ? 'selected' : ''; ?>>
                                                        <?php echo $grupo['gru_nome']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="dataInicial">Data Inicial</label>
                                            <input type="date" class="form-control" id="dataInicial" name="dataInicial" value="<?php echo $dataInicial; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="dataFinal">Data Final</label>
                                            <input type="date" class="form-control" id="dataFinal" name="dataFinal" value="<?php echo $dataFinal; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 d-flex justify-content-between mt-2">
                                        <div class="form-group col-6">
                                            <label class="form-label" for="limpar"></label>
                                            <button type="reset" id="limpar" name="limpar" class="btn btn-warning btn-block">Limpar</button>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="pesquisar"></label>
                                            <button type="submit" id="pesquisar" name="pesquisar" class="btn btn-primary btn-block">Pesquisar</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Relatório -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <h3>Relatório de Produção por Grupo</h3>
                            <div class="table-responsive">
                                <table id="relatorioTable" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>Produtor</th>
                                            <th>Área Produzida (hectares)</th>
                                            <th>Volume Produzido (kg)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($produtores) > 0) {
                                            foreach ($produtores as $produtor) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $produtor['usu_nome']; ?></td>
                                                    <td><?php echo number_format($produtor['area_total'], 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($produtor['volume_total'], 2, ',', '.'); ?></td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td colspan="3" class="text-center">Nenhum dado encontrado para este grupo</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botão de Impressão -->
            <div class="d-flex justify-content-center mt-3 w-100">
                <button onclick="imprimirRelatorio()" class="btn btn-secondary no-print" type="button"><i class="fas fa-print"></i> Imprimir</button>
            </div>

        </div>
    </section>
</div>

<script>
    function imprimirRelatorio() {
        var grupo = $('#grupo').val();
        var dataInicio = $('#dataInicial').val();
        var dataFim = $('#dataFinal').val();

        var url = "/imprimir-porgrupo?" +
            "grupoId=" + encodeURIComponent(grupo) +
            "&dataInicial=" + encodeURIComponent(dataInicio) +
            "&dataFinal=" + encodeURIComponent(dataFim);

        window.open(url, '_blank');
    }
</script>
