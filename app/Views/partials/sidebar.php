<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $baseUrl ?>" class="brand-link" style="background: linear-gradient(<?php echo $corSecundaria ?>,<?php echo $corPrimaria ?>); border: none;">
        <?php if ($urlLogo) {
            echo '<img src="' . $baseUrl . $urlLogo . '" alt="' . $nomeSistema . '" class="w-100 p-3">';
        } else {
            echo '<span class="brand-text font-weight-light ml-3">' . $nomeSistema . '</span>';
        } ?>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: <?php echo $corPrimaria ?>;">
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat" data-widget="treeview" role="menu">
                <hr style="border-top: 1px solid <?= $corSecundaria . '50' ?>; margin: 10px 0;">

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <hr style="border-top: 1px solid <?= $corSecundaria . '50' ?>; margin: 10px 0;">

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>producao" class="nav-link">
                        <i class="nav-icon fas fa-tractor"></i>
                        <p>Gestão da Produção</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>projetos" class="nav-link">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>Gestão de Projetos</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>pedidos" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Pedidos</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>clientes" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Clientes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>financeiro" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>Fluxo de Caixa</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>compras" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Requisições de Compra</p>
                    </a>
                </li>

                <hr style="border-top: 1px solid <?= $corSecundaria . '50' ?>; margin: 10px 0;">

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Cadastros Gerais<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>fazendas" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Fazendas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>tecnicos" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Técnicos/Responsáveis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>produtos" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Produtos e Insumos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>cultivos" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Tipos de Cultivo</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Relatórios<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>relatorio-producao" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Geral de Produção</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>relatorio-financeiro" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Financeiro por Fazenda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>relatorio-compras" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Compras</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>relatorio-pedidos" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Pedidos por Cliente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>relatorio-projetos" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Projetos e Entregas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>relatorio-diagnostico" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Diagnóstico de Plantas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Configurações<i class="right fas fa-angle-left"></i></p>
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
                                <p>Tipo Usuário</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $baseUrl ?>usuarios" class="nav-link">
                                <i class="nav-icon fas fa-caret-right"></i>
                                <p>Usuários</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <hr style="border-top: 1px solid <?= $corSecundaria . '50' ?>; margin: 10px 0;">

                <li class="nav-item">
                    <a href="<?php echo $baseUrl ?>usuario" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
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