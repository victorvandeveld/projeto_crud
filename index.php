<?php
ob_start();
session_start();

if(isset($_SESSION['usuariocli']) && isset($_SESSION['senhacli'])){
	header("Location: clientes/home.php"); 
	exit;
}

require_once 'class/Conexao.class.php';
$conexao = new Conexao();

?>

<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="Projeto CRUD">
        <meta name="description" content="Página de Login">
        <meta name="Keywords" content="Página de Login">
        <meta name="robots" content="index,follow">
        
        <title>Painel Administrativo</title>
        
        <!-- Bootstrap core CSS -->
        <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Custom styles for this template -->
        <link href="css/login.css" rel="stylesheet">
    </head>

    <body>
    
        <div class="container">
            <form class="form-signin" method="post">
            	<?
				if(isset($_GET['acesso'])){
					
					if(!isset($_POST['logar'])){
						$acesso = $_GET['acesso'];
						if($acesso=='negado'){
							echo '<div class="alert alert-danger" role="alert">
									<strong>Erro,</strong> você não esta logado!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
						}
					}
				}
				
				if(isset($_POST['logar'])){
					// Dados do form
					$usuario = trim(strip_tags($_POST['email']));
					$senha = trim(strip_tags($_POST['senha']));
					
					// Select Banco de Dados
					$sql = "SELECT * FROM `administradores` WHERE `adm_email` = '$usuario' AND `adm_senha` = '$senha'";
					
					try{
						$result = $conexao->conectar()->prepare($sql);
						$result->bindParam(':usuario', $usuario, PDO::PARAM_STR);
						$result->bindParam(':senha', $senha, PDO::PARAM_STR);
						$result->execute();
						
						$contar = $result->rowCount();
						if($contar > 0){
							$usuario = $_POST['email'];
							$senha = $_POST['senha'];
							$_SESSION['usuariocli'] = $usuario;
							$_SESSION['senhacli'] = $senha;
							echo '<div class="alert alert-success" role="alert">
								  	Login efetuado com suceso!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
							header("Refresh: 1, clientes/home.php");
							
						} else {
							echo '<div class="alert alert-danger" role="alert">
									<strong>Erro</strong> Usuário / Senha inválidos.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
						}
					}catch(PDOException $ex){
						return 'error '.$ex->getMessage();
					}
				}
				?>
                <h2 class="form-signin-heading">Painel Administrativo</h2>
                <label for="inputEmail" class="sr-only">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
                <br />
                <label for="inputPassword" class="sr-only">Senha</label>
                <input type="password" name="senha" class="form-control" placeholder="Senha" required>
                
                <button class="btn btn-lg btn-primary btn-block" name="logar" type="submit">Entrar</button>
            </form>
        </div> <!-- /container -->
    </body>
</html>
