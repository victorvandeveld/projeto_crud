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
            	<h1 class="page-header">Lista de Clientes</h1>
                <div class="table-responsive">
                	<?
					if(isset($_GET['acao'])){
						if($_GET['acao'] = 'delet'){
							if($clientes->queryDelete($_GET['cli'])){
								echo '<div class="alert alert-success" role="alert">
										<strong>Cliente excluido com sucesso!</strong>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
							}else{
								echo '<div class="alert alert-danger" role="alert">
										<strong>Erro ao excluir Cliente!</strong>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
							}
						}
					}
					?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            	<th>Codigo</th>
                            	<th>Nome</th>
                            	<th>Descrição</th>
                            	<th>Arquivo</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php foreach($clientes->querySelect() as $rst){ ?>
                                <tr>
                                    <td><?=$objFcs->tratarCaracter($rst['vox_id'], 2)?></td>
                                    <td><?=$objFcs->tratarCaracter($rst['vox_nome'], 2)?></td>
                                    <td><?=$objFcs->tratarCaracter(substr($rst['vox_descricao'], 0, 50), 2)?>...</td>
                                    <td>
                                    	<? if(substr($rst['vox_arquivo'], -3) != 'pdf') { ?>
                                    		<a href="#" data-toggle="modal" data-target="#<? echo $rst['vox_id']?>"><?=$objFcs->tratarCaracter($rst['vox_arquivo'], 2)?></a>
                                    	<? } else { ?>
                                        	<a href="../uploads/clientes/<?=$rst['vox_arquivo']?>"><?=$objFcs->tratarCaracter($rst['vox_arquivo'], 2)?></a>
                                        <? } ?>
                                    </td>
                                    <td><a href='alterar_clientes.php?codigo=<?=$rst['vox_id']?>' title="Editar dados"><button type="button" class="btn btn-primary">Alterar</button></a> &nbsp <a href="?acao=delet&cli=<?=$objFcs->base64($rst['vox_id'], 1)?>" onClick="return confirm('Deseja realmente excluir o Cliente?')"  title="Excluir dados"><button type="button" class="btn btn-danger">Excluir</button></a></td>
                                </tr>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="<? echo $rst['vox_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Arquivo <? echo $rst['vox_arquivo']?></h4>
                                             </div>
                                             <div class="modal-body">
                                            	<img src="../uploads/clientes/<? echo $rst['vox_arquivo']?>" style="max-width:1200px"/>
                                        	</div>
                                    	</div>
                                	</div>
                                </div>
                            <?php } ?>    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Incluindo os SCRIPTS -->
	<?php include"../includes/_script.php" ?>
  
</body>
</html>