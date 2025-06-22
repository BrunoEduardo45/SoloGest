<?php
// Dados fictícios para simulação dos gráficos
$produtoresCadastrados = 100;
$gruposCadastrados = 5;
$volumeProducao2025 = 150000; // em Kg
$volumeProducaoTotal = 500000; // em Kg

// Dados de produção por ano e mês
$dadosProducaoAno = [
    '2023' => 130000,
    '2024' => 120000,
    '2025' => $volumeProducao2025,
];

$dadosProducaoMes = [
    'Jan' => 10000,
    'Fev' => 12000,
    'Mar' => 13000,
    'Abr' => 11000,
    'Mai' => 14000,
    'Jun' => 12500, // Dados fictícios para o ano atual
    // Adicione mais meses conforme necessário
];

// Dados fictícios para simulação dos gráficos
$grupos = [
    ['gru_id' => 1, 'gru_nome' => 'Grupo A'],
    ['gru_id' => 2, 'gru_nome' => 'Grupo B'],
    ['gru_id' => 3, 'gru_nome' => 'Grupo C']
];

// Dados fictícios para comparativo entre produtores no grupo
$dadosProducaoProdutores = [
    1 => [
        ['produtor' => 'Produtor A', 'area_produzida' => 50, 'volume_produzido' => 25000],
        ['produtor' => 'Produtor B', 'area_produzida' => 70, 'volume_produzido' => 35000],
    ],
    2 => [
        ['produtor' => 'Produtor C', 'area_produzida' => 60, 'volume_produzido' => 30000],
        ['produtor' => 'Produtor D', 'area_produzida' => 90, 'volume_produzido' => 45000],
    ],
    3 => [
        ['produtor' => 'Produtor E', 'area_produzida' => 100, 'volume_produzido' => 50000],
        ['produtor' => 'Produtor F', 'area_produzida' => 120, 'volume_produzido' => 60000],
    ]
];
?>

<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <!-- Dados Gerais no Topo -->
            <div class="row">
                <!-- Qtd de Produtores Cadastrados -->
                <div class="col-lg-3 col-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $produtoresCadastrados; ?></h3>
                            <p>Produtores Cadastrados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Qtd de Grupos Cadastrados -->
                <div class="col-lg-3 col-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $gruposCadastrados; ?></h3>
                            <p>Grupos Cadastrados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <a href="#" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Volume de Produção 2025 -->
                <div class="col-lg-3 col-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo number_format($volumeProducao2025, 2, ',', '.'); ?> Kg</h3>
                            <p>Produção 2025</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="#" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Volume de Produção Total -->
                <div class="col-lg-3 col-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo number_format($volumeProducaoTotal, 2, ',', '.'); ?> Kg</h3>
                            <p>Produção Total</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <a href="#" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Análise de Produção por Ano e Mês -->
            <div class="row">
                <!-- Produção por Ano -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3>Produção por Ano</h3>
                            <div id="graficoProducaoAno" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Produção por Mês (Ano Atual) -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3>Produção por Mês (2025)</h3>
                            <div id="graficoProducaoMes" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparativo entre Produtores (Após Seleção de Grupo) -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Comparativo entre Produtores</h3>
                            <div class="form-group">
                                <label for="grupoSelect">Selecione o Grupo</label>
                                <select name="grupo" id="grupoSelect" class="form-control" required>
                                    <?php foreach ($grupos as $grupo) { ?>
                                        <option value="<?php echo $grupo['gru_id']; ?>"><?php echo $grupo['gru_nome']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div id="graficoProdutores" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Comparativo Entre Grupos -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Comparativo entre Grupos</h3>
                            <div id="comparativoProducaoGrupos" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>
<script>
    $(document).ready(function() {
        // Gráfico de Produção por Ano
        var dom1 = document.getElementById('graficoProducaoAno');
        var myChart1 = echarts.init(dom1);
        var option1 = {
            tooltip: {
                trigger: 'axis'
            },
            title: {
                text: 'Produção por Ano',
                textStyle: {
                    color: '#a3a3a3'
                }
            },
            xAxis: {
                type: 'category',
                data: ['2025', '2024', '2023']
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: [150000, 120000, 130000],
                type: 'line',
                smooth: true
            }]
        };
        myChart1.setOption(option1);

        // Gráfico de Produção por Mês
        var dom2 = document.getElementById('graficoProducaoMes');
        var myChart2 = echarts.init(dom2);
        var option2 = {
            tooltip: {
                trigger: 'axis'
            },
            title: {
                text: 'Produção por Mês (2025)',
                textStyle: {
                    color: '#a3a3a3'
                }
            },
            xAxis: {
                type: 'category',
                data: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: [10000, 12000, 13000, 11000, 14000, 12500],
                type: 'line',
                smooth: true
            }]
        };
        myChart2.setOption(option2);

        // Gráfico Comparativo entre Grupos
        var dom3 = document.getElementById('comparativoProducaoGrupos');
        var myChart3 = echarts.init(dom3);
        var option3 = {
            tooltip: {
                trigger: 'axis'
            },
            title: {
                text: 'Comparativo entre Grupos',
                textStyle: {
                    color: '#a3a3a3'
                }
            },
            legend: {
                data: ['Área Produzida', 'Volume Produzido'],
                top: '5%'
            },
            xAxis: {
                type: 'category',
                data: ['Grupo A', 'Grupo B', 'Grupo C']
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                    name: 'Área Produzida',
                    type: 'bar',
                    data: [100, 150, 200],
                    itemStyle: {
                        color: '#28A745'
                    }
                },
                {
                    name: 'Volume Produzido',
                    type: 'bar',
                    data: [500, 700, 900],
                    itemStyle: {
                        color: '#17A2B8'
                    }
                }
            ]
        };
        myChart3.setOption(option3);

        // Gráfico de Comparativo entre Produtores
        var myChart = echarts.init(document.getElementById('graficoProdutores'));

        // Função para atualizar o gráfico com os dados dos produtores
        function atualizarGrafico(produtores) {
            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                title: {
                    text: 'Comparativo de Produção entre Produtores',
                    textStyle: {
                        color: '#a3a3a3'
                    }
                },
                legend: {
                    data: ['Área Produzida', 'Volume Produzido'],
                    top: '5%'
                },
                xAxis: {
                    type: 'category',
                    data: produtores.map(p => p.produtor)
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                        name: 'Área Produzida',
                        type: 'bar',
                        data: produtores.map(p => p.area_produzida),
                        itemStyle: {
                            color: '#66CDAA'
                        }
                    },
                    {
                        name: 'Volume Produzido',
                        type: 'bar',
                        data: produtores.map(p => p.volume_produzido),
                        itemStyle: {
                            color: '#FF6347'
                        }
                    }
                ]
            };
            myChart.setOption(option);
        }

        // Atualiza o gráfico ao selecionar um grupo
        $('#grupoSelect').on('change', function() {
            var grupoId = $(this).val();
            if (grupoId) {
                var produtores = <?php echo json_encode($dadosProducaoProdutores); ?>[grupoId];
                atualizarGrafico(produtores);
            }
        });

        atualizarGrafico(<?php echo json_encode($dadosProducaoProdutores); ?>[1])

        myChart4.setOption(option4);
    });
</script>