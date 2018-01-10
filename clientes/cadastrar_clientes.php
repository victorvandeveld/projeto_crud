<?php include"../includes/_require_class.php" ?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<!-- Incluindo do HEAD -->
	<?php include"../includes/_head.php" ?>

<body>
	<!-- Incluindo do HEADER -->
	<?php include"../includes/_header.php" ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Incluindo do SIDEBAR -->
			<?php include"../includes/_sidebar.php" ?>
            
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            	<h1 class="page-header">Cadastrar Cliente</h1>
                <div class="table-responsive">
                	<? 
					if(isset($_POST['btCadastrar'])){
						if($clientes->queryInsert($_POST) == 'ok'){
							echo '<div class="alert alert-success" role="alert">
									<strong>Cadastro efetuado com sucesso!</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
						}else{
							echo '<div class="alert alert-danger" role="alert">
									<strong>Erro ao efetuar o Cadastro!</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
						}
					}
					?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group ">
                            <div class="col-sm-6 col-md-6">
                            	<label>Nome: </label><br>
                            	<input type="text" class="form-control" name="nome" required="required">
                            </div>
                            <div class="col-sm-6 col-md-6">
                            	<label>Arquivo: </label>
                                 <input type="file" class="form-control-file" name="arquivo[]" required="required">
                            </div>
                        </div>
                        
                        <div class="form-group ">
                        	<div class="col-sm-12 col-md-12">
                            	<br>
                            	<label>Descrição: </label><br>
                            	<textarea type="text" class="form-control" rows="5" name="descricao" required="required"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                        	<div class="col-sm-12 col-md-12">
                            	<br>
                        		<button type="submit" name="btCadastrar" class="btn btn-success">Cadastrar</button>
                        
                        		<input type="hidden" name="cli" value="<?=(isset($cli['vox_id']))?($objFcs->base64($cli['vox_id'], 1)):('')?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Incluindo os SCRIPTS -->
	<?php include"../includes/_script.php" ?>
  
</body>
</html>