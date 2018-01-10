<?php
if(isset($_REQUEST['sair'])){
	session_destroy();
	session_unset(['usuariocli']);
	session_unset(['senhacli']);
	header("Location: ../index.php");
}
?>