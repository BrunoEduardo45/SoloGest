<?php
$stmt = $pdo->prepare("SELECT tl_nome, per_visualizar FROM permissao INNER JOIN tela ON (tl_id = per_tela_id) WHERE per_nivel = ?");
$stmt->execute([$nivel]);
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $baseUrl ?>" class="brand-link" style="
        background: linear-gradient(<?php echo $corPrimaria ?>,<?php echo $corSecundaria ?>);
        border-bottom: 1px solid #fff2;
    ">
        <?php if ($urlLogo) {
            echo '<img src="' . $baseUrl . $urlLogo . '" alt="' . $nomeSistema . '" class="w-100 p-3">';
        } else {
            echo '<span class="brand-text font-weight-light ml-3">' . $nomeSistema . '</span>';
        } ?>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: <?php echo $corSecundaria ?>;">

        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <hr style="border-top: 1px solid #fff4; margin: 10px 0;">

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>lista-producao" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Produção</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Cadastros<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>lista-grupos" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Grupos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>lista-produtores" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Produtores</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Relatórios<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>relatorio-porgrupo" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Por Grupo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>relatorio-porprodutor" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Por Produtor</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Configurações
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>configuracao" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Sistema</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>lista-tipousuario" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Tipo Usuario</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>usuarios" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Usuarios</p>
                    </a>
                </li>

                <hr style="border-top: 1px solid #fff4; margin: 10px 0;">

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>usuario" class="nav-link">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>Perfil</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>logout/<?php echo $IdUser ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Sair</p>
                    </a>
                </li>

            </ul>

        </nav>
    </div>
</aside>