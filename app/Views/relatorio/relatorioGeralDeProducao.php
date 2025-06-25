<?php
// Consultas e variaveis
?>

<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">

            <!-- Pesquisa de filtro -->
            <div class="row">
                <div class="col-lg-12">
                    <h1>Relatório Geral de Produção</h1>
                    <div class="card card-outline card-success">
                        <div class="card-body">
                            <h3>Consulta</h3>
                            <hr>
                            <form id="searchRelatorio" method="get">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="produtor">Produtor</label>
                                            <select name="produtorId" id="produtor" class="form-control">
                                                <option value="">Selecione o Produtor</option>
                                                <!-- <?php foreach ($produtores as $produtor) { ?>
                                                    <option value="<?php echo $produtor['prod_id']; ?>" <?php echo ($produtor['prod_id'] == $produtorId) ? 'selected' : ''; ?>>
                                                        <?php echo $produtor['prod_nome']; ?>
                                                    </option>
                                                <?php } ?> -->
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
                                            <button type="submit" id="pesquisar" name="pesquisar" class="btn btn-success btn-block">Pesquisar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Relatório -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline card-success">
                        <div class="card-body">
                            <h3>Resultado</h3>
                            <?php
                            $produtores = [];
                            if (count($produtores) > 0) {
                            ?>
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
                                            <?php foreach ($produtores as $produtor) { ?>
                                                <tr>
                                                    <td><?php echo $produtor['prod_nome']; ?></td>
                                                    <td><?php echo number_format($produtor['area_total'], 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($produtor['volume_total'], 2, ',', '.'); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="3" class="text-center">Nenhum dado encontrado para este produtor</td>
                                </tr>
                            <?php } ?>
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
        var produtor = $('#produtor').val();
        var dataInicio = $('#dataInicial').val();
        var dataFim = $('#dataFinal').val();

        var url = "/imprimir-geraldeproducao?" +
            "produtorId=" + encodeURIComponent(produtor) +
            "&dataInicial=" + encodeURIComponent(dataInicio) +
            "&dataFinal=" + encodeURIComponent(dataFim);

        window.open(url, '_blank');
    }
</script>