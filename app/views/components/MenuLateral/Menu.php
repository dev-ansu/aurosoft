<?php

use app\services\PermissionService;

?>
<nav class="navbar navbar-inverse">
<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <h1><a class="navbar-brand" href="<?= route("/dashboard") ?>"><span class="fa fa-cutlery"></span> Sistema<span class="dashboard_text"><?= @$config->nome ?></span></a></h1>
</div>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="sidebar-menu">
        <li class="header">MENU NAVEGAÇÃO</li>
        <li class="treeview">
            <a href="<?= route("/dashboard") ?>">
                <i class="fa fa-dashboard"></i> <span>Home</span>
            </a>
        </li>


        <?php if(PermissionService::hasGroupPermission('Pessoas')): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Pessoas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if(PermissionService::has('dashboard/usuarios')): ?>
                        <li><a href="<?= route("/dashboard.usuarios") ?>"><i class="fa fa-angle-right"></i> Usuários</a></li>
                        <li><a href="<?= route("/dashboard.funcionarios") ?>"><i class="fa fa-angle-right"></i> Funcionários</a></li>
                        <li><a href="<?= route("/dashboard.fornecedores") ?>"><i class="fa fa-angle-right"></i> Fornecedores</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if(PermissionService::hasGroupPermission('Cadastros')): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-plus"></i>
                    <span>Cadastros</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if(PermissionService::has('dashboard/grupoacessos')): ?>
                        <li><a href="<?= route("/dashboard.grupoacessos") ?>"><i class="fa fa-angle-right"></i> Grupos</a></li>
                    <?php endif; ?>
                    
                    <?php if(PermissionService::has('dashboard/acessos')): ?>
                        <li><a href="<?= route("/dashboard.acessos") ?>"><i class="fa fa-angle-right"></i> Acessos</a></li>
                    <?php endif; ?>

                    <?php if(PermissionService::has('dashboard/formaspagamento')): ?>
                        <li><a href="<?= route("/dashboard.formaspagamento") ?>"><i class="fa fa-angle-right"></i> Formas de pagamento</a></li>
                    <?php endif; ?>
                    
                    <?php if(PermissionService::has('dashboard/frequencias')): ?>
                        <li><a href="<?= route("/dashboard.frequencias") ?>"><i class="fa fa-angle-right"></i> Frequências</a></li>
                    <?php endif; ?>
                    <?php if(PermissionService::has('dashboard/cargos')): ?>
                        <li><a href="<?= route("/dashboard.cargos") ?>"><i class="fa fa-angle-right"></i> Cargos</a></li>
                    <?php endif; ?>
                    
                </ul>
            </li>
         <?php endif; ?>
        <?php if(PermissionService::hasGroupPermission('Financeiro')): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dollar"></i>
                    <span>Financeiro</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if(PermissionService::has('dashboard/contasareceber')): ?>
                        <li><a href="<?= route("/dashboard.contasareceber") ?>"><i class="fa fa-angle-right"></i> Contas a receber</a></li>
                    <?php endif; ?>
                    
                    <?php if(PermissionService::has('dashboard/contasapagar')): ?>
                        <li><a href="<?= route("/dashboard.contasapagar") ?>"><i class="fa fa-angle-right"></i> Contas a pagar</a></li>
                    <?php endif; ?>
                    
                </ul>
            </li>
         <?php endif; ?>

    </ul>
</div>
<!-- /.navbar-collapse -->
</nav>