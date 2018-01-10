<?php
ob_start();
session_start();

if(!isset($_SESSION['usuariocli']) && (!isset($_SESSION['senhacli']))){
	header("Location: ../index.php?acesso=negado"); 
	exit;
}

include"_require_class.php";
include"_logout.php";
?>

<header>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                	<span class="sr-only">Toggle navigation</span>
                	<span class="icon-bar"></span>
                	<span class="icon-bar"></span>
                	<span class="icon-bar"></span>
                </button>
            	<a class="navbar-brand" href="home.php">Projeto CRUD</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <div class="navbar-form navbar-right">
                	<a class="nav-link" href="cadastrar_clientes.php"><button type="button" class="btn btn-success">Cadastrar Clientes</button></a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                	<li><a href="?sair" onClick="return confirm('Deseja realmente sair do Administrador?')">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>