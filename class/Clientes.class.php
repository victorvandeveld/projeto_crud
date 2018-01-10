<?php

include_once "Conexao.class.php";
include_once "Funcoes.class.php";

class Clientes {
    
    private $con;
    private $objfc;
	
    private $vox_id;
    private $vox_nome;
    private $vox_descricao;
	private $vox_arquivo;
    
    public function __construct(){
        $this->con = new Conexao();
        $this->objfc = new Funcoes();
    }
    
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }
    public function __get($atributo){
        return $this->$atributo;
    }
    
    public function querySeleciona($codigo){
        try{
            $sql = $this->con->conectar()->prepare("SELECT * FROM `clientes` WHERE `vox_id` = '$codigo'");
            $sql->execute();
            return $sql->fetch();
        } catch (PDOException $ex) {
            return 'error '.$ex->getMessage();
        }
    }
    
    public function querySelect(){
        try{
            $sql = $this->con->conectar()->prepare("SELECT `vox_id`, `vox_nome`, `vox_descricao`, `vox_arquivo` FROM `clientes`");
            $sql->execute();
            return $sql->fetchAll();
        } catch (PDOException $ex) {
            return 'erro '.$ex->getMessage();
        }
    }
    
    public function queryInsert($dados){
		$this->vox_nome = $this->objfc->tratarCaracter($dados['nome'], 1);
		$this->vox_descricao = $this->objfc->tratarCaracter($dados['descricao'], 1);
		
		//IMAGEM
		$file 		= $_FILES['arquivo'];
		$numFile	= count(array_filter($file['name']));
		
		//PASTA
		$folder		= '../uploads/clientes/';
		
		//REQUISITOS
		$permite 	= array('image/jpeg', 'image/png', 'application/pdf');
		$maxSize	= 1024 * 1024 * 5;
		
		//MENSAGENS
		$msg		= array();
		$errorMsg	= array(
			1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
			2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
			3 => 'o upload do arquivo foi feito parcialmente',
			4 => 'Não foi feito o upload do arquivo'
		);
		
		if($numFile <= 0){
			echo '<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Selecione uma imagem e tente novamente!
					</div>';
		}
		else if($numFile >=2){
			echo '<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Você ultrapassou o limite de upload. Selecione apenas uma foto e tente novamente!
					</div>';
		}else{
			for($i = 0; $i < $numFile; $i++){
				$name 	= $file['name'][$i];
				$type	= $file['type'][$i];
				$size	= $file['size'][$i];
				$error	= $file['error'][$i];
				$tmp	= $file['tmp_name'][$i];
				
				$extensao = @end(explode('.', $name));
				$nomeArquivo = rand().".$extensao";
				
				if($error != 0)
					echo $msg[] = "<b>$name :</b> ".$errorMsg[$error];
				else if(!in_array($type, $permite))
					echo $msg[] = "<b>$name :</b> Erro imagem não suportada!";
				else if($size > $maxSize)
					echo $msg[] = "<b>$name :</b> Erro imagem ultrapassa o limite de 5MB";
				else{
					
					if(move_uploaded_file($tmp, $folder.'/'.$nomeArquivo)){
						try{
							$sql = $this->con->conectar()->prepare("INSERT INTO `clientes` (`vox_nome`, `vox_descricao`, `vox_arquivo`) VALUES (:nome, :descricao, :arquivo)");
							$sql->bindParam(":nome", $this->vox_nome, PDO::PARAM_STR);
							$sql->bindParam(":descricao", $this->vox_descricao, PDO::PARAM_STR);
							$sql->bindParam(":arquivo", $nomeArquivo, PDO::PARAM_STR);
							if($sql->execute()){
								return 'ok';
							}else{
								return 'erro';
							}
						} catch (PDOException $ex) {
							return 'error '.$ex->getMessage();
						}
						
					} else {
							$msg[] = "<b>$name :</b> Desculpe! Ocorreu um erro...";
					}
				}
			
				foreach($msg as $pop)
				echo '';
					//echo $pop.'<br>';
			}
		}
	}
    
    public function queryUpdate($dados){
		$codigo = $_GET['codigo'];
		$select = "SELECT * FROM `clientes` WHERE `vox_id` = '$codigo'";
		$contagem =1;
		
		try{
			$result = $this->con->conectar()->prepare($select);
			$result->bindParam(':codigo', $codigo, PDO::PARAM_INT);			
			$result->execute();
			$contar = $result->rowCount();
			if($contar>0){
				while($mostra = $result->FETCH(PDO::FETCH_OBJ)){
					$id 		= $mostra->vox_id;
					$nome 		= $mostra->vox_nome;
					$descricao	= $mostra->vox_descricao;
					$arquivo 	= $mostra->vox_arquivo;
				}				
			}else{
				echo '<div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Aviso!</strong> Não há dados cadastrados com o id informado.
                </div>';exit;
			}
			
		}catch(PDOException $ex){
			echo $ex;
		}		
		
		$nomeArquivo = $arquivo;
						
		// ATUALIZAR				
	  	if(isset($_POST['btAlterar'])){
			if(!empty($_FILES['arquivo']['name'])){
				//IMAGEM
				$file 		= $_FILES['arquivo'];
				$numFile	= count(array_filter($file['name']));
				
				//PASTA
				$folder		= '../uploads/clientes/';
				
				//REQUISITOS
				$permite 	= array('image/jpeg', 'image/png', 'application/pdf');
				$maxSize	= 1024 * 1024 * 5;
				
				//MENSAGENS
				$msg		= array();
				$errorMsg	= array(
					1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
					2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
					3 => 'o upload do arquivo foi feito parcialmente',
					4 => 'Não foi feito o upload do arquivo'
				);
				
				if($numFile <= 0){
					/*echo '<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							Selecione uma imagem e tente novamente!
						</div>';*/
				} else if($numFile >=2){
					echo '<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								Você ultrapassou o limite de upload. Selecione apenas uma foto e tente novamente!
							</div>';
				} else {
					for($i = 0; $i < $numFile; $i++){
						$name 	= $file['name'][$i];
						$type	= $file['type'][$i];
						$size	= $file['size'][$i];
						$error	= $file['error'][$i];
						$tmp	= $file['tmp_name'][$i];
						
						$extensao = @end(explode('.', $name));
						$nomeArquivo = rand().".$extensao";
						
						if($error != 0)
							$msg[] = "<b>$name :</b> ".$errorMsg[$error];
						else if(!in_array($type, $permite))
							$msg[] = "<b>$name :</b> Erro imagem não suportada!";
						else if($size > $maxSize)
							$msg[] = "<b>$name :</b> Erro imagem ultrapassa o limite de 5MB";
						else{
							
							if(move_uploaded_file($tmp, $folder.'/'.$nomeArquivo)){
								$del = "../uploads/clientes/".$arquivo;
								unlink($del);
														
							} else {
								$msg[] = "<b>$name :</b> Desculpe! Ocorreu um erro...";
							}
						}
						
						foreach($msg as $pop)
						echo '';
							//echo $pop.'<br>';
					}
				}
							
			} else {
				$nomeArquivo = $arquivo;
				echo $nomeArquivo;
				exit;
				
			}
			
			try{
				$this->vox_id = $this->objfc->base64($dados['cli'], 2);
				$this->vox_nome = $this->objfc->tratarCaracter($dados['nome'], 1);
				$this->vox_descricao = $this->objfc->tratarCaracter($dados['descricao'], 1);
				$this->vox_arquivo = $dados['arquivo'];
				$sql = $this->con->conectar()->prepare("UPDATE `clientes` SET `vox_nome` = :nome, `vox_descricao` = :descricao, `vox_arquivo` = :arquivo WHERE `vox_id` = :idcli");
				$sql->bindParam(":idcli", $this->vox_id, PDO::PARAM_INT);
				$sql->bindParam(":nome", $this->vox_nome, PDO::PARAM_STR);
				$sql->bindParam(":descricao", $this->vox_descricao, PDO::PARAM_STR);
				$sql->bindParam(":arquivo", $nomeArquivo, PDO::PARAM_STR);
				if($sql->execute()){
					return 'ok';
				}else{
					return 'erro';
				}
			} catch (PDOException $ex) {
				return 'error '.$ex->getMessage();
			}
		}
    }
		
    public function queryDelete($dado){
        try{
            $this->vox_id = $this->objfc->base64($dado, 2);
            $sql = $this->con->conectar()->prepare("DELETE FROM `clientes` WHERE `vox_id` = :vox_id");
            $sql->bindParam(":vox_id", $this->vox_id, PDO::PARAM_INT);
            if($sql->execute()){
                return 'ok';
            }else{
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error'.$ex->getMessage();
        }
    }
}

?>
