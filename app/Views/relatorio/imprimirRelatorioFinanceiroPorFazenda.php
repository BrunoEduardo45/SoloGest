<?php  
$baseDir = dirname(__FILE__);
include $baseDir . "/../../utils/Database.php";

$idioma = 'pt-BR';
$moeda = 'BRL';

$fmt = new NumberFormatter($idioma, NumberFormatter::CURRENCY); 

$totalGeral = 0; 

// Filtros recebidos via URL
$grupoId = isset($_GET['grupoId']) ? $_GET['grupoId'] : "";
$dataInicial = isset($_GET['dataInicial']) ? $_GET['dataInicial'] : "";
$dataFinal = isset($_GET['dataFinal']) ? $_GET['dataFinal'] : "";

// Dados fictícios para o relatório
$dados = [
    ['TipoFidelidade' => 'Tipo 1', 'ValorTotal' => 5000],
    ['TipoFidelidade' => 'Tipo 2', 'ValorTotal' => 3000],
    ['TipoFidelidade' => 'Tipo 3', 'ValorTotal' => 2000],
];

// Verificando o grupo selecionado
if ($grupoId) {
    $grupo = selecionarDoBanco('grupos', 'gru_nome', 'gru_id = '.$grupoId, [], [])[0]['gru_nome'];
} else {
    $grupo = "Todos os Grupos";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório por Grupo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sub p {
            border-bottom: 1px solid #c1c1c1; 
            margin-bottom: 5px; 
        }
        hr {
            margin-top: 25px;
            margin-bottom: 25px;
        }

        @media print {
            p, td {
                font-size: 16px;
            }
            .no-print {
                display: none;
            }
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .content  {
            flex: 1;
        }
    </style>
</head>
<body>
<div class="container mt-3">

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between">
        <div class="col-4">
            <img src="<?php echo $baseUrl.$urlLogo ?>" class="w-50" style="background-color: <?php echo $corPrimaria ?>; border-radius: 5px;">
            <div class="mt-3 w-100">
                <p class="m-0 pl-1"><?php echo $descricaoSistema ?></p>
                <p class="m-0 pl-1"><b>Email: </b><?php echo $emailPadrao ?></p>
            </div>
        </div>
        <div class="col-8 text-right">
            <h1 style="color: <?php echo $corPrimaria ?>;"> Relatório de Produção por Grupo </h1>
            <div class="row justify-content-end">
                <div class="col-12 text-right p-0">
                    <p class="mb-1 mr-3 mt-3" style="font-weight: bold;"> Data </p>
                </div>
                <div class="col-3">
                    <div class="text-center" style="border: <?php echo $corPrimaria ?> solid 1px;">
                        <p class="m-0" style="border: <?php echo $corPrimaria ?> solid 1px;"> <?php echo date("d/m/Y") ?> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dados pesquisa -->
    <?php if ($dataInicial != "" || $dataFinal != "" || $grupoId != "") { ?>
        <div class="row mt-5 ml-1 mr-0">
            <div class="col-12">
                <p class="p-2 m-0" style="background-color: <?php echo $corPrimaria ?>; color: #fff;"><b class="ml-2"> Dados da Pesquisa </b></p>
                <div class="row">
                    <div class="col-6 sub">
                        <?php if ($dataInicial != "") { ?>
                            <p class="m-0 p-1"><b> Data Inicial: </b><?php echo $dataInicial; ?></p>
                        <?php } ?>
                        <?php if ($dataFinal != "") { ?>
                            <p class="m-0 p-1"><b> Data Final: </b><?php echo $dataFinal; ?></p>
                        <?php } ?>
                    </div>
                    <div class="col-6 sub">
                        <?php if ($grupoId != "") { ?>
                            <p class="m-0 p-1"><b> Grupo: </b><?php echo $grupo; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Dados -->
    <div class="mt-4 mr-3 ml-3" style="border: solid <?php echo $corPrimaria ?> 3px; border-top: 0px;">
        <div style="background-color: <?php echo $corPrimaria ?>; color: #fff">
            <div class="row">
                <div class="col-12 d-flex">
                    <div class="col-6 p-0">
                        <p class="m-0 p-2"> Tipo de Fidelidade </p>
                    </div>
                    <div class="col-6 p-0 text-right">
                        <p class="m-0 p-2"> Total </p>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-sm m-0">
            <tbody>
                <?php 
                    foreach ($dados as $item) { 
                    $totalGeral += $item['ValorTotal'];
                ?>
                    <tr>
                        <td class="col-6" style="border-right: solid <?php echo $corPrimaria ?> 3px;">
                            <?php echo $item['TipoFidelidade']; ?>
                        </td>
                        <td class="col-6 text-right">
                            <?php echo $fmt->formatCurrency($item['ValorTotal'], $moeda); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="row mt-4 mr-1 ml-0">
        <div class="col-10 text-right">
            <p style="margin: 1px 0px; font-weight: bold;"> Total Geral </p> 
        </div>
        <div class="col-2">
            <div class="text-right" style="border: <?php echo $corPrimaria ?> solid 1px;">
                <p class="m-0 pr-2" style="border: <?php echo $corPrimaria ?> solid 1px;"> <?php echo $fmt->formatCurrency($totalGeral, $moeda) ?> </p>
            </div>
        </div>
    </div>
 
    <!-- Botões -->
    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary"><i class="fa fa-print mr-2"></i> Imprimir </button>
        <button onclick="gerarPDF()" class="btn btn-secondary"><i class="fas fa-file-pdf mr-2"></i> Gerar PDF</button>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function gerarPDF() {
        const conteudo = document.querySelector('.container');
        const options = {
            margin: 10,
            filename: 'Relatorio_Grupo_<?php echo date("d_m_Y") ?>.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().from(conteudo).set(options).save();
    }
</script>

</body>
</html>
